#!/usr/bin/python
# -*- coding: utf-8 -*-
'''
Copyright (C) 2010 by Diederik van Liere (dvanliere@gmail.com)
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details, at
http://www.fsf.org/licenses/gpl.html
'''

__author__ = '''\n'''.join(['Diederik van Liere (dvanliere@gmail.com)', ])
__email__ = 'dvanliere at gmail dot com'
__date__ = '2010-10-21'
__version__ = '0.1'

import os
import logging
import logging.handlers
import sys
import datetime
from argparse import ArgumentParser
from argparse import RawTextHelpFormatter
import ConfigParser

import configuration
from utils import file_utils
from utils import ordered_dict
from utils import log
from utils import timer
from classes import wikiprojects
from database import db
from etl import downloader
from etl import extracter
from etl import store
from etl import sort
from etl import transformer
from analyses import analyzer


def show_choices(settings, attr):
    choices = getattr(settings, attr).items()
    choices.sort()
    choices = ['%s\t%s' % (choice[0], choice[1]) for choice in choices]
    return choices



def config_launcher(properties, settings, logger):
    '''
    Config launcher is used to reconfigure editor trends toolkit. 
    '''
#    settings.load_configuration()
#
    if not os.path.exists('wiki.cfg') or properties.force:
        config = ConfigParser.RawConfigParser()
        project = None
        language = None
        #language_map = languages.language_map()
        working_directory = raw_input('Please indicate where you installed Editor Trends Analytics.\nCurrent location is %s\nPress Enter to accept default.\n' % os.getcwd())
        input_location = raw_input('Please indicate where to store the Wikipedia dump files.\nDefault is: %s\nPress Enter to accept default.\n' % settings.input_location)

        while project not in properties.projects.keys():
            project = raw_input('Please indicate which project you would like to analyze.\nDefault is: %s\nPress Enter to accept default.\n' % properties.projects[properties.short_project].capitalize())
            project = project if len(project) > 0 else properties.short_project
            if project not in properties.projects.keys():
                print 'Valid choices for a project are: %s' % ','.join(properties.projects.keys())

        while language not in properties.valid_languages:
            language = raw_input('Please indicate which language of project %s you would like to analyze.\nDefault is: %s\nPress Enter to accept default.\n' % (properties.projects[project].capitalize(), properties.language))
            if len(language) == 0:
                language = properties.language_code
            language = language if language in properties.valid_languages else properties.language

        input_location = input_location if len(input_location) > 0 else settings.input_location
        working_directory = working_directory if len(working_directory) > 0 else os.getcwd()

        config = ConfigParser.RawConfigParser()
        config.add_section('file_locations')
        config.set('file_locations', 'working_directory', working_directory)
        config.set('file_locations', 'input_location', input_location)
        config.add_section('wiki')
        config.set('wiki', 'project', project)
        config.set('wiki', 'language', language)

        fh = file_utils.create_binary_filehandle(working_directory, 'wiki.cfg', 'wb')
        config.write(fh)
        fh.close()

        settings.working_directory = config.get('file_locations', 'working_directory')
        settings.input_location = config.get('file_locations', 'input_location')




def downloader_launcher(properties, settings, logger):
    '''
    This launcher calls the dump downloader to download a Wikimedia dump file.
    '''
    print 'Start downloading'
    stopwatch = timer.Timer()
    #project, language, jobtype, task, timer, event = 'start'
    log.log_to_mongo(properties, 'dataset', 'download', stopwatch, event='start')
    downloader.launcher(properties, settings, logger)
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'download', stopwatch, event='finish')



def extract_launcher(properties, settings, logger):
    '''
    The extract launcher is used to extract the required variables from a dump
    file. If the zip file is a known archive then it will first launch the
    unzip launcher. 
    '''
    print 'Extracting data from XML'
    stopwatch = timer.Timer()
    log.log_to_mongo(properties, 'dataset', 'extract', stopwatch, event='start')
    extracter.launcher(properties)
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'extract', stopwatch, event='finish')


def sort_launcher(properties, settings, logger):
    '''
    After the extracter has finished then the created output files need to be
    sorted. This function takes care of that. 
    '''
    print 'Start sorting data'
    stopwatch = timer.Timer()
    log.log_to_mongo(properties, 'dataset', 'sort', stopwatch, event='start')
#    write_message_to_log(logger, settings,
#                         message=None,
#                         verb=None,
#                         location=properties.location,
#                         input=properties.txt,
#                         output=properties.sorted)
    sort.mergesort_launcher(properties.txt, properties.sorted)
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'sort', stopwatch, event='finish')


def store_launcher(properties, settings, logger):
    '''
    The data is ready to be stored once the sorted function has completed. This
    function starts storing data in MongoDB.
    '''
    print 'Start storing data in MongoDB'
    stopwatch = timer.Timer()
    log.log_to_mongo(properties, 'dataset', 'store', stopwatch, event='start')
    db.cleanup_database(properties.project, logger)
#    write_message_to_log(logger, settings,
#                         message=None,
#                         verb='Storing',
#                         function=properties.function,
#                         location=properties.location,
#                         input=properties.sorted,
#                         project=properties.full_project,
#                         collection=properties.collection)
    for key in properties:
        print key, getattr(properties, key)
    store.launcher(properties.sorted, properties.project, properties.collection)
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'store', stopwatch, event='finish')


def transformer_launcher(properties, settings, logger):
    print 'Start transforming dataset'
    stopwatch = timer.Timer()
    log.log_to_mongo(properties, 'dataset', 'transform', stopwatch, event='start')
    db.cleanup_database(properties.project, logger, 'dataset')
#    write_message_to_log(logger, settings,
#                         message=None,
#                         verb='Transforming',
#                         project=properties.project,
#                         collection=properties.collection)
    transformer.transform_editors_single_launcher(properties.project,
                                                  properties.collection)
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'transform', stopwatch,
                     event='finish')


def exporter_launcher(properties, settings, logger):
    print 'Start exporting dataset'
    stopwatch = timer.Timer()
    log.log_to_mongo(properties, 'dataset', 'export', stopwatch, event='start')
    for target in properties.targets:
#        write_message_to_log(logger, settings,
#                             message=None,
#                             verb='Exporting',
#                             target=target,
#                             dbname=properties.full_project,
#                             collection=properties.collection)
        print 'Dataset is created by: %s' % target

        analyzer.generate_chart_data(properties.project,
                                     properties.collection,
                                     properties.language_code,
                                     target)
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'export', stopwatch, event='finish')


def cleanup(properties, settings, logger):
    directories = properties.directories[1:]
    for directory in directories:
        write_message_to_log(logger, setting,
                             message=None,
                             verb='Deleting',
                             dir=directory)
        file_utils.delete_file(directory, '', directory=True)

    write_message_to_log(logger, settings,
                         message=None,
                         verb='Creating',
                         dir=directories)
    settings.verify_environment(directories)

    filename = '%s%s' % (properties.full_project, '_editor.bin')
    write_message_to_log(logger, settings,
                         message=None,
                         verb='Deleting',
                         filename=filename)
    file_utils.delete_file(settings.binary_location, filename)


def all_launcher(properties, settings, logger):
    print 'The entire data processing chain has been called, this will take a \
    couple of hours (at least) to complete.'
    print properties.__dict__
    stopwatch = timer.Timer()
    log.log_to_mongo(properties, 'dataset', 'all', stopwatch, event='start')
    print 'Start of building %s dataset.' % properties.project

#    write_message_to_log(logger, settings,
#                         message=message,
#                         verb=None,
#                         full_project=properties.full_project,
#                         ignore=properties.ignore,
#                         clean=properties.clean)
    if properties.clean:
        cleanup(properties, settings, logger)

    functions = ordered_dict.OrderedDict(((downloader_launcher, 'download'),
                                          (extract_launcher, 'extract'),
                                          (sort_launcher, 'sort'),
                                          (store_launcher, 'store'),
                                          (transformer_launcher, 'transform'),
                                          (exporter_launcher, 'export')))

    for function, callname in functions.iteritems():
        if callname not in properties.ignore:
            print 'Starting %s' % function.func_name
            res = function(properties, settings, logger)
            if res == False:
                sys.exit(False)
            elif res == None:
                print 'Function %s does not return a status, \
                implement NOW' % function.func_name
    stopwatch.elapsed()
    log.log_to_mongo(properties, 'dataset', 'all', stopwatch, event='finish')


def show_languages(settings, logger, properties):
    first = properties.get_value('startswith')
    if first != None:
        first = first.title()
    choices = languages.supported_languages()
    lang = []
    for choice in choices:
        lang.append(choice)
    lang.sort()
    for language in lang:
        try:
            if first != None and language.startswith(first):
                print '%s' % language.decode(settings.encoding)
            elif first == None:
                print '%s' % language.decode(settings.encoding)
        except UnicodeEncodeError:
            print '%s' % language


def about_statement():
    print ''
    print 'Editor Trends Software is (c) 2010-2011 by the Wikimedia Foundation.'
    print 'Written by Diederik van Liere (dvanliere@gmail.com).'
    print '''This software comes with ABSOLUTELY NO WARRANTY.\nThis is 
    free software, and you are welcome to distribute it under certain 
    conditions.'''
    print 'See the README.1ST file for more information.'
    print ''


def init_args_parser():
    '''
    Entry point for parsing command line and launching the needed function(s).
    '''
    settings = configuration.Settings()
    default_language = wikiprojects.determine_default_language()
    wiki = wikiprojects.Wiki(settings)
    projects = wiki.projects.keys()
    #Init Argument Parser
    parser = ArgumentParser(prog='manage', formatter_class=RawTextHelpFormatter)
    subparsers = parser.add_subparsers(help='sub - command help')

    #SHOW LANGUAGES
    parser_languages = subparsers.add_parser('show_languages',
        help='Overview of all valid languages.')
    parser_languages.add_argument('-s', '--startswith',
        action='store',
        help='Enter the first letter of a language to see which languages are \
        available.')
    parser_languages.set_defaults(func=show_languages)

    #CONFIG 
    parser_config = subparsers.add_parser('config',
        help='The config sub command allows you set the data location of where \
        to store files.')
    parser_config.set_defaults(func=config_launcher)
    parser_config.add_argument('-f', '--force',
        action='store_true',
        help='Reconfigure Editor Toolkit (this will replace wiki.cfg')

    #DOWNLOAD
    parser_download = subparsers.add_parser('download',
        help='The download sub command allows you to download a Wikipedia dump\
         file.')
    parser_download.set_defaults(func=downloader_launcher)

    #EXTRACT
    parser_create = subparsers.add_parser('extract',
        help='The store sub command parsers the XML chunk files, extracts the \
        information and stores it in a MongoDB.')
    parser_create.set_defaults(func=extract_launcher)


    #SORT
    parser_sort = subparsers.add_parser('sort',
        help='By presorting the data, significant processing time reductions \
        are achieved.')
    parser_sort.set_defaults(func=sort_launcher)

    #STORE
    parser_store = subparsers.add_parser('store',
        help='The store sub command parsers the XML chunk files, extracts the \
        information and stores it in a MongoDB.')
    parser_store.set_defaults(func=store_launcher)

    #TRANSFORM
    parser_transform = subparsers.add_parser('transform',
        help='Transform the raw datatable to an enriched dataset that can be \
        exported.')
    parser_transform.set_defaults(func=transformer_launcher)

    #EXPORT
    parser_dataset = subparsers.add_parser('export',
        help='Create a dataset from the MongoDB and write it to a csv file.')
    parser_dataset.set_defaults(func=exporter_launcher)

    #ALL
    parser_all = subparsers.add_parser('all',
        help='The all sub command runs the download, split, store and dataset \
        commands.\n\nWARNING: THIS COULD TAKE DAYS DEPENDING ON THE \
        CONFIGURATION OF YOUR MACHINE AND THE SIZE OF THE WIKIMEDIA DUMP FILE.')
    parser_all.set_defaults(func=all_launcher)
    parser_all.add_argument('-e', '--except',
        action='store',
        help='Should be a list of functions that are to be ignored when \
        executing all.',
        default=[])

    parser_all.add_argument('-n', '--new',
        action='store_true',
        help='This will delete all previous output and starts from scratch. \
        Mostly useful for debugging purposes.',
        default=False)

    #DJANGO
    parser_django = subparsers.add_parser('django')
    parser_django.add_argument('-e', '--except',
        action='store',
        help='Should be a list of functions that are to be ignored when \
        executing all.',
        default=[])


    parser.add_argument('-l', '--language',
        action='store',
        help='Example of valid languages.',
        choices=wiki.supported_languages(),
        default=default_language)

    parser.add_argument('-p', '--project',
        action='store',
        help='Specify the Wikimedia project that you would like to download',
        choices=projects,
        default='wiki')

    parser.add_argument('-c', '--collection',
        action='store',
        help='Name of MongoDB collection',
        default='editors')

    parser.add_argument('-o', '--location',
        action='store',
        help='Indicate where you want to store the downloaded file.',
        default=settings.input_location)

    parser.add_argument('-ns', '--namespace',
        action='store',
        help='A list of namespaces to include for analysis.',
        default='0')

    parser.add_argument('-f', '--file',
        action='store',
        choices=settings.file_choices,
        help='Indicate which dump you want to download. Valid choices are:\n \
            %s' % ''.join([f + ',\n' for f in settings.file_choices]),
        default='stub-meta-history.xml.gz')

    parser.add_argument('-d', '--datasets',
        action='store',
        choices=analyzer.available_analyses(),
        help='Indicate what type of data should be exported.',
        default='cohort_dataset_backward_bar')

    return parser, settings, wiki

def main():
    parser, settings, wiki = init_args_parser()
    args = parser.parse_args()
    properties = wikiprojects.Wiki(settings, args)
    #initialize logger
    logger = logging.getLogger('manager')
    logger.setLevel(logging.DEBUG)

    # Add the log message handler to the logger
    today = datetime.datetime.today()
    log_filename = os.path.join(settings.log_location, '%s%s_%s-%s-%s.log' \
        % (properties.language_code, properties.project,
           today.day, today.month, today.year))
    handler = logging.handlers.RotatingFileHandler(log_filename,
                                                   maxBytes=1024 * 1024,
                                                   backupCount=3)

    logger.addHandler(handler)
    logger.debug('Chosen language: \t%s' % wiki.language)

    #start manager
    #detect_python_version(logger)
    about_statement()
    config.create_configuration(settings, args)

    properties.show_settings()
    args.func(properties, settings, logger)


if __name__ == '__main__':
    main()

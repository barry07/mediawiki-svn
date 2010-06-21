<?php
/*
 (c) Aaron Schulz, Joerg Baach, 2007-2008 GPL
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

# This messes with dump HTML...
if ( defined( 'MW_HTML_FOR_DUMP' ) ) {
	return;
}

# Quality -> Sighted (default)
if ( !defined( 'FLAGGED_VIS_QUALITY' ) )
	define( 'FLAGGED_VIS_QUALITY', 0 );
# No precedence
if ( !defined( 'FLAGGED_VIS_LATEST' ) )
	define( 'FLAGGED_VIS_LATEST', 1 );
# Pristine -> Quality -> Sighted
if ( !defined( 'FLAGGED_VIS_PRISTINE' ) )
	define( 'FLAGGED_VIS_PRISTINE', 2 );
	
# SELECT parameters...
if ( !defined( 'FR_FOR_UPDATE' ) )
	define( 'FR_FOR_UPDATE', 1 );
if ( !defined( 'FR_MASTER' ) )
	define( 'FR_MASTER', 2 );
if ( !defined( 'FR_TEXT' ) )
	define( 'FR_TEXT', 3 );

# Level constants...
if ( !defined( 'FR_SIGHTED' ) )
	define( 'FR_SIGHTED', 0 );
if ( !defined( 'FR_QUALITY' ) )
	define( 'FR_QUALITY', 1 );
if ( !defined( 'FR_PRISTINE' ) )
	define( 'FR_PRISTINE', 2 );

# Include settings
if ( !defined( 'FR_INCLUDES_CURRENT' ) )
	define( 'FR_INCLUDES_CURRENT', 0 );
if ( !defined( 'FR_INCLUDES_FREEZE' ) )
	define( 'FR_INCLUDES_FREEZE', 1 );
if ( !defined( 'FR_INCLUDES_STABLE' ) )
	define( 'FR_INCLUDES_STABLE', 2 );
	
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Flagged Revisions',
	'author'         => array( 'Aaron Schulz', 'Joerg Baach' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:FlaggedRevs',
	'descriptionmsg' => 'flaggedrevs-desc',
);

# ######## Configuration variables ########
# IMPORTANT: DO NOT EDIT THIS FILE
# When configuring globals, set them at LocalSettings.php instead

# This will only distinguish "sigted", "quality", and unreviewed
# A small icon will show in the upper right hand corner
$wgSimpleFlaggedRevsUI = true;
# For visitors, only show tags/icons for unreviewed/outdated pages
$wgFlaggedRevsLowProfile = true;

# Allowed namespaces of reviewable pages
$wgFlaggedRevsNamespaces = array( NS_MAIN, NS_FILE, NS_TEMPLATE );

# Pages exempt from reviewing
$wgFlaggedRevsWhitelist = array();
# $wgFlaggedRevsWhitelist = array( 'Main_Page' );

# Do flagged revs override the default view?
$wgFlaggedRevsOverride = true;
# Are pages only reviewable if the stable shows by default?
$wgFlaggedRevsReviewForDefault = false;
# Precedence order for stable version selection.
# The stable version will be the highest ranked version in the page.
# FR_PRISTINE : "pristine" > "quality" > "sighted"
# FR_QUALITY : "pristine" = "quality" > "sighted"
# FR_SIGHTED : "pristine" = "quality" = "sighted"
$wgFlaggedRevsPrecedence = FR_QUALITY;
# Revision tagging can slow development...
# For example, the main user base may become complacent, perhaps treat flagged
# pages as "done", or just be too lazy to click "current". We may just want non-user
# visitors to see reviewed pages by default.
# Below are groups that see the current revision by default.
$wgFlaggedRevsExceptions = array( 'user' );

# Can users make comments that will show up below flagged revisions?
$wgFlaggedRevsComments = false;
# Allow auto-review edits directly to the stable version by reviewers?
$wgFlaggedRevsAutoReview = true;
# Auto-review new pages with the minimal level?
$wgFlaggedRevsAutoReviewNew = true;

# Define the tags we can use to rate an article, number of levels,
# and set the minimum level to have it become a "quality" or "pristine" version.
# NOTE: When setting up new dimensions or levels, you will need to add some
# 		MediaWiki messages for the UI to show properly; any sysop can do this.
$wgFlaggedRevTags = array(
	'accuracy' => array( 'levels' => 3, 'quality' => 2, 'pristine' => 4 ),
	'depth'    => array( 'levels' => 3, 'quality' => 1, 'pristine' => 4 ),
	'style'    => array( 'levels' => 3, 'quality' => 1, 'pristine' => 4 ),
);

# For each tag, define the highest tag level that is unlocked by
# having certain rights. For example, having 'review' rights may
# allow for "depth" to be rated up to second level.
# NOTE: Users cannot lower tags from a level they can't set.
# NOTE: Users with 'validate' can do anything regardless.
# This is mainly for custom, less experienced, groups
$wgFlagRestrictions = array(
	'accuracy' => array( 'review' => 1, 'autoreview' => 1 ),
	'depth'	   => array( 'review' => 2, 'autoreview' => 2 ),
	'style'	   => array( 'review' => 3, 'autoreview' => 3 ),
);
# For each tag, what is the highest level that it can be auto-reviewed to?
# $wgFlaggedRevsAutoReview must be enabled for this to apply.
$wgFlaggedRevsTagsAuto = array(
	'accuracy' => 1, 'depth' => 1, 'style' => 1
);

# Restriction levels for 'autoreview'/'review' rights.
# When a level is selected for a page, an edit made by a user
# requires approval unless that user has the specified permission.
# Levels are set at the Stabilization special page.
$wgFlaggedRevsRestrictionLevels = array( '', 'sysop' );
# Set this to disable Stabilization and show the above restriction levels
# on the protection form of pages. Each level has the stable version shown by default.
# A "none" level will appear in the forms as well, to restore the default settings.
# NOTE: The stable version precedence cannot be configured per page with this.
$wgFlaggedRevsProtection = false;

# Please set these as something different. Any text will do, though it probably
# shouldn't be very short (less secure) or very long (waste of resources).
# There must be two codes, and only the first two are checked.
$wgReviewCodes = array();

# URL location for flaggedrevs.css and flaggedrevs.js
# Use a literal $wgScriptPath as a placeholder for the runtime value of $wgScriptPath
$wgFlaggedRevsStylePath = '$wgScriptPath/extensions/FlaggedRevs/client';

# Define our basic reviewer class
$wgGroupPermissions['editor']['review']          = true;
$wgGroupPermissions['editor']['autoreview']      = true;
$wgGroupPermissions['editor']['autoconfirmed']   = true;
$wgGroupPermissions['editor']['unreviewedpages'] = true;
$wgGroupPermissions['editor']['patrolmarks']     = true;

# Defines extra rights for advanced reviewer class
$wgGroupPermissions['reviewer']['validate']        = true;
# Let this stand alone just in case...
$wgGroupPermissions['reviewer']['review']          = true;
$wgGroupPermissions['reviewer']['autoreview']      = true;
$wgGroupPermissions['reviewer']['autoconfirmed']   = true;
$wgGroupPermissions['reviewer']['unreviewedpages'] = true;
$wgGroupPermissions['reviewer']['patrolmarks']     = true;

# Sysops have their edits autoreviewed
$wgGroupPermissions['sysop']['autoreview'] = true;
# Stable version selection and default page revision selection can be set per page.
$wgGroupPermissions['sysop']['stablesettings'] = true;
# Sysops can always move stable pages
$wgGroupPermissions['sysop']['movestable'] = true;

# Define when users get automatically promoted to Editors. Set as false to disable.
# 'spacing' and 'benchmarks' require edits to be spread out. Users must have X (benchmark)
# edits Y (spacing) days apart.
$wgFlaggedRevsAutopromote = array(
	'days'	              => 60, # days since registration
	'edits'	              => 250, # total edit count
	'excludeDeleted'      => true, # exclude deleted edits from 'edits' count above?
	// Require 'benchmark' edits 'spacing' days apart from each other
	'spacing'	          => 3, # spacing of edit intervals
	'benchmarks'          => 15, # how many edit intervals are needed?
	'recentContentEdits'  => 0, # $wgContentNamespaces edits in recent changes
	// Either totalContentEdits reqs OR totalCheckedEdits requirements needed
	'totalContentEdits'   => 300, # $wgContentNamespaces edits OR...
	'totalCheckedEdits'   => 200, # ...Edits before the stable version of pages
	'uniqueContentPages'  => 12, # $wgContentNamespaces unique pages edited
	'editComments'        => 50, # how many edit comments used?
	'userpageBytes'       => 0, # userpage is needed? with what min size?
	'uniqueIPAddress'     => false, # If $wgPutIPinRC is true, users sharing IPs won't be promoted
	'neverBlocked'        => true, # Can users that were blocked be promoted?
	'maxRevertedEdits'    => 5, # Max edits the user could have had rolled back?
);

# Define when users get to have their own edits auto-reviewed. Set to false to disable.
# This can be used for newer, semi-trusted users to improve workflow.
# It is done by granting some users the implicit 'autoreview' group.
$wgFlaggedRevsAutoconfirm = false;
/* (example usage)
$wgFlaggedRevsAutoconfirm = array(
	'days'	              => 30, # days since registration
	'edits'	              => 50, # total edit count
	'spacing'	          => 3, # spacing of edit intervals
	'benchmarks'          => 7, # how many edit intervals are needed?
	// Either totalContentEdits reqs OR totalCheckedEdits requirements needed
	'totalContentEdits'   => 150, # $wgContentNamespaces edits OR...
	'totalCheckedEdits'   => 50, # ...Edits before the stable version of pages
	'uniqueContentPages'  => 8, # $wgContentNamespaces unique pages edited
	'editComments'        => 20, # how many edit comments used?
	'email'	              => false, # user must be emailconfirmed?
	'neverBlocked'        => true, # Can users that were blocked be promoted?
);
*/

# Special:Userrights settings
# # Basic rights for Sysops
$wgAddGroups['sysop'][] = 'editor';
$wgRemoveGroups['sysop'][] = 'editor';
# # Extra ones for Bureaucrats
$wgAddGroups['bureaucrat'][] = 'reviewer';
$wgRemoveGroups['bureaucrat'][] = 'reviewer';

# Show reviews in recentchanges? Disabled by default, often spammy...
$wgFlaggedRevsLogInRC = false;
# Show automatic promotions to Editor in RC? Disabled by default, often spammy...
$wgFlaggedRevsAutopromoteInRC = false;

# How far the logs for overseeing quality revisions and depreciations go
$wgFlaggedRevsOversightAge = 30 * 24 * 3600;

# Flagged revisions are always visible to users with rights below.
# Use '*' for non-user accounts.
$wgFlaggedRevsVisible = array();
# If $wgFlaggedRevsVisible is populated, it is applied to talk pages too
$wgFlaggedRevsTalkVisible = true;

# How long before Special:ValidationStatistics is updated
$wgFlaggedRevsStatsAge = 2 * 3600; // 2 hours

# How to handle templates and files used in stable versions:
# FR_INCLUDES_CURRENT
#	Always use the current version of templates/files
# FR_INCLUDES_FREEZE
#	Use the version of templates/files that the page used when reviewed
# FR_INCLUDES_STABLE
# 	Use the stable version of templates/files that themselves have a stable version
#	and the template/file version used at the time of review for those that don't have one
$wgFlaggedRevsHandleIncludes = FR_INCLUDES_STABLE;

# NOTE: ignore the next two settings if set to FR_CURRENT_INCLUDES.

# We may have templates that do not have stable version. Given situational
# inclusion of templates (such as parser functions that select template
# X or Y depending), there may also be no revision ID for each template
# pointed to by the metadata of how the article was when it was reviewed.
# An example would be an article that selects a template based on time.
# The template to be selected will change, and the metadata only points
# to the reviewed revision ID of the old template. In such cases, we can s
# select the current (unreviewed) revision.
$wgUseCurrentTemplates = true;

# We may have file pages that do not have stable version. Given situational
# inclusion of templates/files (such as a random featured image template), 
# there may also be no sha-1/time for each file pointed to by the metadata 
# of how the article was when it was reviewed. In such cases, we can select 
# the current (unreviewed) revision.
$wgUseCurrentImages = true;

# End of configuration variables.
# ########

# Patrollable namespaces (overridden by reviewable namespaces)
$wgFlaggedRevsPatrolNamespaces = array();

# Bots are granted autoreview via hooks, mark in rights 
# array so that it shows up in sp:ListGroupRights...
$wgGroupPermissions['bot']['autoreview'] = true;

# Lets some users access the review UI and set some flags
$wgAvailableRights[] = 'review';
$wgAvailableRights[] = 'validate'; # Let some users set higher settings
$wgAvailableRights[] = 'autoreview';
$wgAvailableRights[] = 'unreviewedpages';
$wgAvailableRights[] = 'movestable';
$wgAvailableRights[] = 'stablesettings';

# Bump this number every time you change flaggedrevs.css/flaggedrevs.js
$wgFlaggedRevStyleVersion = 76;

$wgExtensionFunctions[] = 'efLoadFlaggedRevs';

$dir = dirname( __FILE__ ) . '/';
$langDir = $dir . 'language/';

$wgSvgGraphDir = $dir . 'svggraph';
$wgPHPlotDir = $dir . 'phplot-5.0.5';

$wgAutoloadClasses['FlaggedRevs'] = $dir . 'FlaggedRevs.class.php';
$wgAutoloadClasses['FlaggedRevsHooks'] = $dir . 'FlaggedRevs.hooks.php';
$wgAutoloadClasses['FlaggedRevsLogs'] = $dir . 'FlaggedRevsLogs.php';
$wgAutoloadClasses['FRCacheUpdate'] = $dir . 'FRCacheUpdate.php';
$wgAutoloadClasses['FRCacheUpdateJob'] = $dir . 'FRCacheUpdate.php';
$wgAutoloadClasses['FRLinksUpdate'] = $dir . 'FRLinksUpdate.php';

# Special case cache invalidations
$wgJobClasses['flaggedrevs_CacheUpdate'] = 'FRCacheUpdateJob';

$wgExtensionMessagesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.i18n.php';
$wgExtensionAliasesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.alias.php';

# Load general UI
$wgAutoloadClasses['FlaggedRevsXML'] = $dir . 'FlaggedRevsXML.php';
# Load web request context article stuff
$wgAutoloadClasses['FlaggedArticleView'] = $dir . 'FlaggedArticleView.php';
# Load FlaggedArticle object class
$wgAutoloadClasses['FlaggedArticle'] = $dir . 'FlaggedArticle.php';
# Load FlaggedRevision object class
$wgAutoloadClasses['FlaggedRevision'] = $dir . 'FlaggedRevision.php';

# Load review form
$wgAutoloadClasses['RevisionReviewForm'] = $dir . 'forms/RevisionReviewForm.php';
# Load protection/stability form
$wgAutoloadClasses['PageStabilityForm'] = $dir . 'forms/PageStabilityForm.php';
$wgAutoloadClasses['PageStabilityGeneralForm'] = $dir . 'forms/PageStabilityForm.php';
$wgAutoloadClasses['PageStabilityProtectForm'] = $dir . 'forms/PageStabilityForm.php';

# Load revision review UI
$wgAutoloadClasses['RevisionReview'] = $dir . 'specialpages/RevisionReview_body.php';
# Load reviewed versions UI
$wgAutoloadClasses['ReviewedVersions'] = $dir . 'specialpages/ReviewedVersions_body.php';
$wgExtensionMessagesFiles['ReviewedVersions'] = $langDir . 'ReviewedVersions.i18n.php';
# Stable version config
$wgAutoloadClasses['Stabilization'] = $dir . 'specialpages/Stabilization_body.php';
$wgExtensionMessagesFiles['Stabilization'] = $langDir . 'Stabilization.i18n.php';
# Load unreviewed pages list
$wgAutoloadClasses['UnreviewedPages'] = $dir . 'specialpages/UnreviewedPages_body.php';
$wgExtensionMessagesFiles['UnreviewedPages'] = $langDir . 'UnreviewedPages.i18n.php';
$wgSpecialPageGroups['UnreviewedPages'] = 'quality';
# Load "in need of re-review" pages list
$wgAutoloadClasses['OldReviewedPages'] = $dir . 'specialpages/OldReviewedPages_body.php';
$wgExtensionMessagesFiles['OldReviewedPages'] = $langDir . 'OldReviewedPages.i18n.php';
$wgSpecialPageGroups['OldReviewedPages'] = 'quality';
# Load "suspicious changes" pages list
$wgAutoloadClasses['ProblemChanges'] = $dir . 'specialpages/ProblemChanges_body.php';
$wgExtensionMessagesFiles['ProblemChanges'] = $langDir . 'ProblemChanges.i18n.php';
$wgSpecialPageGroups['ProblemChanges'] = 'quality';
# Load reviewed pages list
$wgAutoloadClasses['ReviewedPages'] = $dir . 'specialpages/ReviewedPages_body.php';
$wgExtensionMessagesFiles['ReviewedPages'] = $langDir . 'ReviewedPages.i18n.php';
$wgSpecialPageGroups['ReviewedPages'] = 'quality';
# Load stable pages list (for protection config)
$wgAutoloadClasses['StablePages'] = $dir . 'specialpages/StablePages_body.php';
$wgExtensionMessagesFiles['StablePages'] = $langDir . 'StablePages.i18n.php';
$wgSpecialPageGroups['StablePages'] = 'quality';
# Load configured pages list (non-protection config)
$wgAutoloadClasses['ConfiguredPages'] = $dir . 'specialpages/ConfiguredPages_body.php';
$wgExtensionMessagesFiles['ConfiguredPages'] = $langDir . 'ConfiguredPages.i18n.php';
$wgSpecialPageGroups['ConfiguredPages'] = 'quality';
# To oversee quality revisions
$wgAutoloadClasses['QualityOversight'] = $dir . 'specialpages/QualityOversight_body.php';
$wgExtensionMessagesFiles['QualityOversight'] = $langDir . 'QualityOversight.i18n.php';
$wgSpecialPageGroups['QualityOversight'] = 'quality';
# Statistics
$wgAutoloadClasses['ValidationStatistics'] = $dir . 'specialpages/ValidationStatistics_body.php';
$wgExtensionMessagesFiles['ValidationStatistics'] = $langDir . 'ValidationStatistics.i18n.php';
$wgSpecialPageGroups['ValidationStatistics'] = 'quality';

# API Modules
$wgAutoloadClasses['FlaggedRevsApiHooks'] = $dir . 'api/FlaggedRevsApi.hooks.php';
# OldReviewedPages for API
$wgAutoloadClasses['ApiQueryOldreviewedpages'] = $dir . 'api/ApiQueryOldreviewedpages.php';
$wgAPIListModules['oldreviewedpages'] = 'ApiQueryOldreviewedpages';
# UnreviewedPages for API
$wgAutoloadClasses['ApiQueryUnreviewedpages'] = $dir . 'api/ApiQueryUnreviewedpages.php';
# ReviewedPages for API
$wgAutoloadClasses['ApiQueryReviewedpages'] = $dir . 'api/ApiQueryReviewedpages.php';
# Flag metadata for pages for API
$wgAutoloadClasses['ApiQueryFlagged'] = $dir . 'api/ApiQueryFlagged.php';
$wgAPIPropModules['flagged'] = 'ApiQueryFlagged';
# Site flag config for API
$wgAutoloadClasses['ApiFlagConfig'] = $dir . 'api/ApiFlagConfig.php';
$wgAPIModules['flagconfig'] = 'ApiFlagConfig';

# Page review module for API
$wgAutoloadClasses['ApiReview'] = $dir . 'api/ApiReview.php';
$wgAPIModules['review'] = 'ApiReview';
# Stability config module for API
$wgAutoloadClasses['ApiStabilize'] = $dir . 'api/ApiStabilize.php';
$wgAutoloadClasses['ApiStabilizeGeneral'] = $dir . 'api/ApiStabilize.php';
$wgAutoloadClasses['ApiStabilizeProtect'] = $dir . 'api/ApiStabilize.php';

# New user preferences
$wgDefaultUserOptions['flaggedrevssimpleui'] = (int)$wgSimpleFlaggedRevsUI;
$wgDefaultUserOptions['flaggedrevsstable'] = false;
$wgDefaultUserOptions['flaggedrevseditdiffs'] = true;
$wgDefaultUserOptions['flaggedrevsviewdiffs'] = false;

# ####### HOOK TRIGGERED FUNCTIONS  #########

# ######## User interface #########
# Override current revision, add patrol links, set cache...
$wgHooks['ArticleViewHeader'][] = 'FlaggedRevsHooks::onArticleViewHeader';
$wgHooks['ImagePageFindFile'][] = 'FlaggedRevsHooks::onImagePageFindFile';
# Override redirect behavior...
$wgHooks['InitializeArticleMaybeRedirect'][] = 'FlaggedRevsHooks::overrideRedirect';
# Set page view tabs
$wgHooks['SkinTemplateTabs'][] = 'FlaggedRevsHooks::setActionTabs'; // Most skins
$wgHooks['SkinTemplateNavigation'][] = 'FlaggedRevsHooks::setNavigation'; // Vector
# Add notice tags to edit view
$wgHooks['EditPage::showEditForm:initial'][] = 'FlaggedRevsHooks::addToEditView';
# Tweak submit button name/title
$wgHooks['EditPageBeforeEditButtons'][] = 'FlaggedRevsHooks::onBeforeEditButtons';
# Autoreview information from form
$wgHooks['EditPageBeforeEditChecks'][] = 'FlaggedRevsHooks::addReviewCheck';
$wgHooks['EditPage::showEditForm:fields'][] = 'FlaggedRevsHooks::addRevisionIDField';
# Add draft link to section edit error
$wgHooks['EditPageNoSuchSection'][] = 'FlaggedRevsHooks::onNoSuchSection';
# Add notice tags to history
$wgHooks['PageHistoryBeforeList'][] = 'FlaggedRevsHooks::addToHistView';
# Add review form and visiblity settings link
$wgHooks['SkinAfterContent'][] = 'FlaggedRevsHooks::onSkinAfterContent';
# Mark items in page history
$wgHooks['PageHistoryPager::getQueryInfo'][] = 'FlaggedRevsHooks::addToHistQuery';
$wgHooks['PageHistoryLineEnding'][] = 'FlaggedRevsHooks::addToHistLine';
$wgHooks['LocalFile::getHistory'][] = 'FlaggedRevsHooks::addToFileHistQuery';
$wgHooks['ImagePageFileHistoryLine'][] = 'FlaggedRevsHooks::addToFileHistLine';
# Mark items in RC
$wgHooks['SpecialRecentChangesQuery'][] = 'FlaggedRevsHooks::addToRCQuery';
$wgHooks['SpecialWatchlistQuery'][] = 'FlaggedRevsHooks::addToWatchlistQuery';
$wgHooks['ChangesListInsertArticleLink'][] = 'FlaggedRevsHooks::addToChangeListLine';
# Page review on edit
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'FlaggedRevsHooks::injectPostEditURLParams';
# Diff-to-stable
$wgHooks['DiffViewHeader'][] = 'FlaggedRevsHooks::onDiffViewHeader';
# Add diff=review url param alias
$wgHooks['NewDifferenceEngine'][] = 'FlaggedRevsHooks::checkDiffUrl';
# Local user account preference
$wgHooks['GetPreferences'][] = 'FlaggedRevsHooks::onGetPreferences';
# Show unreviewed pages links
$wgHooks['CategoryPageView'][] = 'FlaggedRevsHooks::onCategoryPageView';
# Backlog notice
$wgHooks['SiteNoticeAfter'][] = 'FlaggedRevsHooks::addBacklogNotice';
# Review/stability log links
$wgHooks['LogLine'][] = 'FlaggedRevsHooks::logLineLinks';

# Add CSS/JS and review notice
$wgHooks['BeforePageDisplay'][] = 'FlaggedRevsHooks::onBeforePageDisplay';
# Add global JS vars
$wgHooks['MakeGlobalVariablesScript'][] = 'FlaggedRevsHooks::injectGlobalJSVars';

# Add flagging data to ApiQueryRevisions
$wgHooks['APIGetAllowedParams'][] = 'FlaggedRevsApiHooks::addApiRevisionParams';
$wgHooks['APIQueryAfterExecute'][] = 'FlaggedRevsApiHooks::addApiRevisionData';
# ########

# ######## Parser #########
# Parser hooks, selects the desired images/templates
$wgHooks['ParserClearState'][] = 'FlaggedRevsHooks::parserAddFields';
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'FlaggedRevsHooks::parserFetchStableTemplate';
$wgHooks['BeforeParserMakeImageLinkObj'][] = 'FlaggedRevsHooks::parserMakeStableFileLink';
$wgHooks['BeforeGalleryFindFile'][] = 'FlaggedRevsHooks::galleryFindStableFileTime';
# Additional parser versioning
$wgHooks['ParserAfterTidy'][] = 'FlaggedRevsHooks::parserInjectTimestamps';
$wgHooks['OutputPageParserOutput'][] = 'FlaggedRevsHooks::outputInjectTimestamps';
# ########

# ######## DB write operations #########
# Autopromote Editors
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevsHooks::maybeMakeEditor';
# Auto-reviewing
$wgHooks['RecentChange_save'][] = 'FlaggedRevsHooks::autoMarkPatrolled';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevsHooks::maybeMakeEditReviewed';
# Null edit review via checkbox
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevsHooks::maybeNullEditReview';
# Disable auto-promotion for demoted users
$wgHooks['UserRights'][] = 'FlaggedRevsHooks::recordDemote';
# User edit tallies
$wgHooks['ArticleRollbackComplete'][] = 'FlaggedRevsHooks::incrementRollbacks';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevsHooks::incrementReverts';
# Extra cache updates for stable versions
$wgHooks['HTMLCacheUpdate::doUpdate'][] = 'FlaggedRevsHooks::doCacheUpdate';
# Updates stable version tracking data
$wgHooks['LinksUpdate'][] = 'FlaggedRevsHooks::onLinksUpdate';
# Clear dead config rows
$wgHooks['ArticleDeleteComplete'][] = 'FlaggedRevsHooks::onArticleDelete';
$wgHooks['ArticleRevisionVisibilitySet'][] = 'FlaggedRevsHooks::onRevisionDelete';
$wgHooks['ArticleRevisionVisiblitySet'][] = 'FlaggedRevsHooks::onRevisionDelete'; // B/C for now
$wgHooks['TitleMoveComplete'][] = 'FlaggedRevsHooks::onTitleMoveComplete';
# Check on undelete/merge for changes to stable version
$wgHooks['ArticleMergeComplete'][] = 'FlaggedRevsHooks::updateFromMerge';
$wgHooks['ArticleRevisionUndeleted'][] = 'FlaggedRevsHooks::onRevisionRestore';
# ########

# ######## Other #########
# Determine what pages can be moved and patrolled
$wgHooks['getUserPermissionsErrors'][] = 'FlaggedRevsHooks::onUserCan';
# Implicit autoreview rights group
$wgHooks['GetAutoPromoteGroups'][] = 'FlaggedRevsHooks::checkAutoPromote';

# Check if a page is currently being reviewed
$wgHooks['MediaWikiPerformAction'][] = 'FlaggedRevsHooks::onMediaWikiPerformAction';

# Actually register special pages
$wgHooks['SpecialPage_initList'][] = 'FlaggedRevsHooks::defineSpecialPages';

# Stable dump hook
$wgHooks['WikiExporter::dumpStableQuery'][] = 'FlaggedRevsHooks::stableDumpQuery';

# Duplicate flagged* tables in parserTests.php
$wgHooks['ParserTestTables'][] = 'FlaggedRevsHooks::onParserTestTables';

# Database schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'FlaggedRevsHooks::addSchemaUpdates';
# ########

function efSetFlaggedRevsConditionalHooks() {
	global $wgHooks, $wgFlaggedRevsVisible;
	# Mark items in user contribs
	if ( !FlaggedRevs::stableOnlyIfConfigured() ) {
		$wgHooks['ContribsPager::getQueryInfo'][] = 'FlaggedRevsHooks::addToContribsQuery';
		$wgHooks['ContributionsLineEnding'][] = 'FlaggedRevsHooks::addToContribsLine';
	}
	# Visibility - experimental
	if ( !empty( $wgFlaggedRevsVisible ) ) {
		$wgHooks['getUserPermissionsErrors'][] = 'FlaggedRevsHooks::userCanView';
	}
	if ( FlaggedRevs::useProtectionLevels() ) {
		# Add protection form field
		$wgHooks['ProtectionForm::buildForm'][] = 'FlaggedRevsHooks::onProtectionForm';
		$wgHooks['ProtectionForm::showLogExtract'][] = 'FlaggedRevsHooks::insertStabilityLog';
		# Save stability settings
		$wgHooks['ProtectionForm::save'][] = 'FlaggedRevsHooks::onProtectionSave';
	}
	# Give bots the 'autoreview' right (here so it triggers after CentralAuth)
	# @TODO: better way to ensure hook order
	$wgHooks['UserGetRights'][] = 'FlaggedRevsHooks::onUserGetRights';
}

# ####### END HOOK TRIGGERED FUNCTIONS  #########

function efLoadFlaggedRevs() {
	global $wgUseRCPatrol, $wgFlaggedRevsNamespaces;
	# If patrolling is already on, then we know that it 
	# was intended to have all namespaces patrollable.
	if ( $wgUseRCPatrol ) {
		global $wgFlaggedRevsPatrolNamespaces, $wgCanonicalNamespaceNames;
		$wgFlaggedRevsPatrolNamespaces = array_keys( $wgCanonicalNamespaceNames );
	}
	/* TODO: decouple from rc patrol */
	# Check if FlaggedRevs is enabled by default for pages...
	if ( $wgFlaggedRevsNamespaces && !FlaggedRevs::stableOnlyIfConfigured() ) {
		# Use RC Patrolling to check for vandalism.
		# Edits to reviewable pages must be flagged to be patrolled.
		$wgUseRCPatrol = true;
	}
	# Conditional API modules
	efSetFlaggedRevsConditionalAPIModules();
	# Load hooks that aren't always set
	efSetFlaggedRevsConditionalHooks();
	# Remove conditionally applicable rights
	efSetFlaggedRevsConditionalRights();
	# Defaults for user preferences
	efSetFlaggedRevsConditionalPreferences();
}

function efSetFlaggedRevsConditionalAPIModules() {
	global $wgAPIModules, $wgAPIListModules;
	if ( FlaggedRevs::stableOnlyIfConfigured() ) {
		$wgAPIModules['stabilize'] = 'ApiStabilizeProtect';
	} else {
		$wgAPIModules['stabilize'] = 'ApiStabilizeGeneral';
		$wgAPIListModules['reviewedpages'] = 'ApiQueryReviewedpages';
		$wgAPIListModules['unreviewedpages'] = 'ApiQueryUnreviewedpages';
	}
}

function efSetFlaggedRevsConditionalRights() {
	global $wgGroupPermissions, $wgImplicitGroups, $wgFlaggedRevsAutoconfirm;
	if ( FlaggedRevs::stableOnlyIfConfigured() ) {
		// Removes sp:ListGroupRights cruft
		if ( isset( $wgGroupPermissions['editor'] ) ) {
			unset( $wgGroupPermissions['editor']['unreviewedpages'] );
		}
		if ( isset( $wgGroupPermissions['reviewer'] ) ) {
			unset( $wgGroupPermissions['reviewer']['unreviewedpages'] );
		}
	}
	if ( !empty( $wgFlaggedRevsAutoconfirm ) ) {
		# Implicit autoreview group
		$wgGroupPermissions['autoreview']['autoreview'] = true;
		# Don't show the 'autoreview' group everywhere
		$wgImplicitGroups[] = 'autoreview';
	}
}

function efSetFlaggedRevsConditionalPreferences() {
	global $wgDefaultUserOptions, $wgSimpleFlaggedRevsUI;
	$wgDefaultUserOptions['flaggedrevssimpleui'] = (int)$wgSimpleFlaggedRevsUI;
}

# Add review log
$wgLogTypes[] = 'review';
$wgFilterLogTypes['review'] = true;
$wgLogNames['review'] = 'review-logpage';
$wgLogHeaders['review'] = 'review-logpagetext';
# Various actions are used for log filtering ...
$wgLogActions['review/approve']  = 'review-logentry-app'; // sighted (again)
$wgLogActions['review/approve2']  = 'review-logentry-app'; // quality (again)
$wgLogActions['review/approve-i']  = 'review-logentry-app'; // sighted (first time)
$wgLogActions['review/approve2-i']  = 'review-logentry-app'; // quality (first time)
$wgLogActions['review/approve-a']  = 'review-logentry-app'; // sighted (auto)
$wgLogActions['review/approve2-a']  = 'review-logentry-app'; // quality (auto)
$wgLogActions['review/approve-ia']  = 'review-logentry-app'; // sighted (initial & auto)
$wgLogActions['review/approve2-ia']  = 'review-logentry-app'; // quality (initial & auto)
$wgLogActions['review/unapprove'] = 'review-logentry-dis'; // was sighted
$wgLogActions['review/unapprove2'] = 'review-logentry-dis'; // was quality

# Add stable version log
$wgLogTypes[] = 'stable';
$wgLogNames['stable'] = 'stable-logpage';
$wgLogHeaders['stable'] = 'stable-logpagetext';
$wgLogActionsHandlers['stable/config'] = 'FlaggedRevsLogs::stabilityLogText'; // customize
$wgLogActionsHandlers['stable/modify'] = 'FlaggedRevsLogs::stabilityLogText'; // re-customize
$wgLogActionsHandlers['stable/reset'] = 'FlaggedRevsLogs::stabilityLogText'; // reset

# AJAX functions
$wgAjaxExportList[] = 'RevisionReview::AjaxReview';
$wgAjaxExportList[] = 'FlaggedArticleView::AjaxBuildDiffHeaderItems';

# Cache update
$wgSpecialPageCacheUpdates[] = 'efFlaggedRevsUnreviewedPagesUpdate';

function efFlaggedRevsUnreviewedPagesUpdate() {
	$base = dirname( __FILE__ );
	require_once( "$base/maintenance/updateQueryCache.inc" );
	update_flaggedrevs_querycache();
	require_once( "$base/maintenance/updateStats.inc" );
	update_flaggedrevs_stats();
}

# B/C ...
$wgLogActions['rights/erevoke']  = 'rights-editor-revoke';


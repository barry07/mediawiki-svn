%define _basedir /opt/TSperl
%include Solaris.inc

Name:		TSperl-IO-Compress-Bzip2
Summary:	IO::Compress::Bzip2 module for Perl
Version:	2.015
Source:		http://search.cpan.org/CPAN/authors/id/P/PM/PMQS/IO-Compress-Bzip2-2.015.tar.gz

SUNW_BaseDir:	%{_basedir}
BuildRoot:	%{_tmppath}/%{name}-%{version}-build
%include default-depend.inc

Requires: TSperl
Requires: TSperl-IO-Compress-Base
Requires: TSperl-Compress-Raw-Bzip2
BuildRequires: TSperl
BuildRequires: TSperl-IO-Compress-Base
BuildRequires: TSperl-Compress-Raw-Bzip2

%prep
%setup -q -n IO-Compress-Bzip2-%version

%build

echo n | /opt/TSperl/bin/perl Makefile.PL INSTALLDIRS=vendor
make

%install
rm -rf $RPM_BUILD_ROOT

make DESTDIR=$RPM_BUILD_ROOT install
rm $RPM_BUILD_ROOT%{_libdir}/5.8/perllocal.pod
rmdir $RPM_BUILD_ROOT%{_libdir}/5.8
find $RPM_BUILD_ROOT%{_libdir} -name .packlist -exec rm {} +

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr (-, root, bin)
%dir %attr (0755, root, bin) %{_libdir}
%dir %attr (0755, root, bin) %{_libdir}/vendor_perl
%dir %attr (0755, root, bin) %{_libdir}/vendor_perl/5.8
%{_libdir}/vendor_perl/5.8/*
%dir %attr (0755, root, sys) %{_datadir}
%dir %attr (0755, root, bin) %{_mandir}
%dir %attr (0755, root, bin) %{_mandir}/man3
%{_mandir}/man3/*

%changelog
* Fri Jan 30 2009 - river@loreley.flyingparchment.org.uk
- Initial spec

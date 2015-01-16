
Name: app-print-server
Epoch: 1
Version: 2.0.14
Release: 1%{dist}
Summary: Advanced Print Server
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-groups
Requires: app-users
Requires: app-network

%description
The Advanced Print Server app provides a common print interface to printers on the network.  This allows clients on the LAN to share print resources and eases administration into one centralized service.

%package core
Summary: Advanced Print Server - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-certificate-manager-core
Requires: app-events-core
Requires: app-groups-core
Requires: app-network-core >= 1:1.6.0
Requires: app-print-server-plugin-core
Requires: app-users-core
Requires: cups >= 1.4.2-44.v6.1
Requires: csplugin-filewatch
Requires: foomatic

%description core
The Advanced Print Server app provides a common print interface to printers on the network.  This allows clients on the LAN to share print resources and eases administration into one centralized service.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/print_server
cp -r * %{buildroot}/usr/clearos/apps/print_server/

install -d -m 0755 %{buildroot}/etc/clearos/print_server.d
install -d -m 0775 %{buildroot}/var/cache/cups
install -d -m 0755 %{buildroot}/var/clearos/print_server
install -d -m 0755 %{buildroot}/var/clearos/print_server/backup/
install -D -m 0755 packaging/accounts-event %{buildroot}/var/clearos/events/accounts/print_server
install -D -m 0644 packaging/cups.php %{buildroot}/var/clearos/base/daemon/cups.php
install -D -m 0644 packaging/cupsd.listen.conf %{buildroot}/etc/cups/cupsd.listen.conf
install -D -m 0644 packaging/cupsd.location.conf %{buildroot}/etc/cups/cupsd.location.conf
install -D -m 0644 packaging/cupsd.policy.conf %{buildroot}/etc/cups/cupsd.policy.conf
install -D -m 0644 packaging/filewatch-print-server-configuration.conf %{buildroot}/etc/clearsync.d/filewatch-print-server-configuration.conf
install -D -m 0644 packaging/filewatch-print-server-printers.conf %{buildroot}/etc/clearsync.d/filewatch-print-server-printers.conf
install -D -m 0755 packaging/network-configuration-event %{buildroot}/var/clearos/events/network_configuration/print_server
install -D -m 0644 packaging/print_server.conf %{buildroot}/etc/clearos/print_server.conf

%post
logger -p local6.notice -t installer 'app-print-server - installing'

%post core
logger -p local6.notice -t installer 'app-print-server-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/print_server/deploy/install ] && /usr/clearos/apps/print_server/deploy/install
fi

[ -x /usr/clearos/apps/print_server/deploy/upgrade ] && /usr/clearos/apps/print_server/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-print-server - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-print-server-core - uninstalling'
    [ -x /usr/clearos/apps/print_server/deploy/uninstall ] && /usr/clearos/apps/print_server/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/print_server/controllers
/usr/clearos/apps/print_server/htdocs
/usr/clearos/apps/print_server/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/print_server/packaging
%dir /usr/clearos/apps/print_server
%dir /etc/clearos/print_server.d
%dir %attr(0775,root,lp) /var/cache/cups
%dir /var/clearos/print_server
%dir /var/clearos/print_server/backup/
/usr/clearos/apps/print_server/deploy
/usr/clearos/apps/print_server/language
/usr/clearos/apps/print_server/libraries
/var/clearos/events/accounts/print_server
/var/clearos/base/daemon/cups.php
%config(noreplace) /etc/cups/cupsd.listen.conf
/etc/cups/cupsd.location.conf
/etc/cups/cupsd.policy.conf
/etc/clearsync.d/filewatch-print-server-configuration.conf
/etc/clearsync.d/filewatch-print-server-printers.conf
/var/clearos/events/network_configuration/print_server
%config(noreplace) /etc/clearos/print_server.conf

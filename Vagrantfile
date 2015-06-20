# -*- mode: ruby -*-
# vi: set ft=ruby :
# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  # All Vagrant configuration is done here. The most common configuration
  # options are documented and commented below. For a complete reference,
  # please see the online documentation at vagrantup.com.

  # General parameters
  host_ip = '192.168.1.53'
  eth = 'en0'
  interfaces = ["lo", "eth0"]

  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "deb/jessie-amd64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  config.vm.box_check_update = true

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 10080
  config.vm.network "forwarded_port", guest: 443, host: 10443
  config.vm.network "forwarded_port", guest: 13306, host: 13306
  config.vm.network "forwarded_port", guest: 9091, host: 9091

  config.vm.network :private_network, ip: "192.0.0.2"
  config.vm.synced_folder '.', '/vagrant', nfs: true
  config.ssh.insert_key = 'true'

  # VirtualBox
  config.vm.provider "virtualbox" do |v|
    host = RbConfig::CONFIG['host_os']
    mem = 850

    if host =~ /darwin/
      cpus = `sysctl -n hw.ncpu`.to_i
    elsif host =~ /linux/
      cpus = `nproc`.to_i
    else
      cpus = 2
    end

    v.gui = true

    v.customize ["modifyvm", :id, "--memory", mem]
    v.customize ["modifyvm", :id, "--cpus", cpus]
  end

  # Do port forwarding for each interface in both localhost and machine IP

  config.trigger.after [:provision, :up, :reload, :resume] do

    host = RbConfig::CONFIG['host_os']
    #host_ip = '192.168.1.53'
    #eth = 'en0'

    if host =~ /darwin/
      system('echo "
        rdr pass on %ETH% inet proto tcp from any to %HOST_IP% port 80 -> 127.0.0.1 port 10080
        rdr pass on %ETH% inet proto tcp from any to %HOST_IP% port 443 -> 127.0.0.1 port 10443
        rdr pass on %ETH% inet proto tcp from any to %HOST_IP% port 13306 -> 127.0.0.1 port 13306
        rdr pass on lo0 inet proto tcp from any to 127.0.0.1 port 80 -> 127.0.0.1 port 10080
        rdr pass on lo0 inet proto tcp from any to 127.0.0.1 port 443 -> 127.0.0.1 port 10443
        rdr pass on lo0 inet proto tcp from any to 127.0.0.1 port 13306 -> 127.0.0.1 port 13306
        rdr pass on lo0 inet proto tcp from any to %HOST_IP% port 80 -> 127.0.0.1 port 10080
        rdr pass on lo0 inet proto tcp from any to %HOST_IP% port 443 -> 127.0.0.1 port 10443
        rdr pass on lo0 inet proto tcp from any to %HOST_IP% port 13306 -> 127.0.0.1 port 13306
        " | sudo pfctl -e -f - > /dev/null 2>&1; echo "==> Forwarding Ports: 80 -> 10080, 443 -> 10443, 8000 to %HOST_IP% on %ETH%"'.gsub("%HOST_IP%", host_ip).gsub("%ETH%", eth))
    else
      system("sudo iptables -t nat -A OUTPUT -o lo -p tcp -d 127.0.0.1 --dport 80 -j REDIRECT --to-port 10080;
              sudo iptables -t nat -A OUTPUT -o lo -p tcp -d %HOST_IP% --dport 80 -j REDIRECT --to-port 10080;
              echo '==> Forwarding Ports: 80 -> 10080'").gsub("%HOST_IP%", host_ip)
    end

  end

  config.trigger.after [:suspend, :halt, :destroy] do

    host = RbConfig::CONFIG['host_os']

    if host =~ /darwin/
      system("sudo pfctl -d -f /etc/pf.conf > /dev/null 2>&1; echo '==> Removing Port Forwarding'")
    else
     system("sudo iptables -t nat -D OUTPUT -o lo -p tcp -d 127.0.0.1 --dport 80 -j REDIRECT --to-port 10080;
             sudo iptables -t nat -D OUTPUT -o lo -p tcp -d %HOST_IP% --dport 80 -j REDIRECT --to-port 10080;
             echo '==> Removing Port Forwarding'").gsub("%HOST_IP%", host_ip)
    end

  end

  # iptables -t nat --list
  #system("sudo iptables -t nat -I OUTPUT 1 -p tcp -d 127.0.0.1 --dport 80 -j REDIRECT --to-ports 10080; echo '==> Forwarding Ports: 80 -> 10080'")
     #system("sudo iptables -t nat -D OUTPUT 1; echo '==> Removing Port Forwarding'")

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # If true, then any SSH connections made will enable agent forwarding.
  # Default value: false
  # config.ssh.forward_agent = true

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Don't boot with headless mode
  #   vb.gui = true
  #
  #   # Use VBoxManage to customize the VM. For example to change memory:
  #   vb.customize ["modifyvm", :id, "--memory", "1024"]
  # end
  #
  # View the documentation for the provider you're using for more
  # information on available options.

  config.vm.provision :shell, inline: File.read("deploy/local/bootstrap.sh", :encoding => "UTF-8")

  #
  # Enable provisioning with CFEngine. CFEngine Community packages are
  # automatically installed. For example, configure the host as a
  # policy server and optionally a policy file to run:
  #
  # config.vm.provision "cfengine" do |cf|
  #   cf.am_policy_hub = true
  #   # cf.run_file = "motd.cf"
  # end
  #
  # You can also configure and bootstrap a client to an existing
  # policy server:
  #
  # config.vm.provision "cfengine" do |cf|
  #   cf.policy_server_address = "10.0.2.15"
  # end

  # Enable provisioning with Puppet stand alone.  Puppet manifests
  # are contained in a directory path relative to this Vagrantfile.
  # You will need to create the manifests directory and a manifest in
  # the file default.pp in the manifests_path directory.
  #
  # config.vm.provision "puppet" do |puppet|
  #   puppet.manifests_path = "manifests"
  #   puppet.manifest_file  = "site.pp"
  # end

  # Enable provisioning with chef solo, specifying a cookbooks path, roles
  # path, and data_bags path (all relative to this Vagrantfile), and adding
  # some recipes and/or roles.
  #
  # config.vm.provision "chef_solo" do |chef|
  #   chef.cookbooks_path = "../my-recipes/cookbooks"
  #   chef.roles_path = "../my-recipes/roles"
  #   chef.data_bags_path = "../my-recipes/data_bags"
  #   chef.add_recipe "mysql"
  #   chef.add_role "web"
  #
  #   # You may also specify custom JSON attributes:
  #   chef.json = { :mysql_password => "foo" }
  # end

  # Enable provisioning with chef server, specifying the chef server URL,
  # and the path to the validation key (relative to this Vagrantfile).
  #
  # The Opscode Platform uses HTTPS. Substitute your organization for
  # ORGNAME in the URL and validation key.
  #
  # If you have your own Chef Server, use the appropriate URL, which may be
  # HTTP instead of HTTPS depending on your configuration. Also change the
  # validation key to validation.pem.
  #
  # config.vm.provision "chef_client" do |chef|
  #   chef.chef_server_url = "https://api.opscode.com/organizations/ORGNAME"
  #   chef.validation_key_path = "ORGNAME-validator.pem"
  # end
  #
  # If you're using the Opscode platform, your validator client is
  # ORGNAME-validator, replacing ORGNAME with your organization name.
  #
  # If you have your own Chef Server, the default validation client name is
  # chef-validator, unless you changed the configuration.
  #
  #   chef.validation_client_name = "ORGNAME-validator"
end
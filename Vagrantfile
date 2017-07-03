# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "icpabelona/adzbuzz"

  config.vm.network "forwarded_port", guest: 80, host: 8000

  config.vm.network "forwarded_port", guest: 3306, host: 33060

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder "~", "/vagrant_data"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "512"
  end

  config.vm.provision :shell, :path => "scripts/bootstrap.sh"
end

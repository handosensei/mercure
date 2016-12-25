# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    config.vm.box = "bento/debian-7.8"
    config.vm.network "private_network", ip: "192.168.9.3"
    config.vm.synced_folder ".", "/var/www", type: "nfs"
    config.vm.provision :shell, :path => "provision.sh"
    config.ssh.username = "vagrant"
    config.ssh.password = "vagrant"
end

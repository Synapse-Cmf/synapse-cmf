# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.define :local, primary: true do |local|

        local.vm.box = "ubuntu/trusty64"

        local.vm.provider "virtualbox" do |vb|
            vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
            vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
            vb.customize ["modifyvm", :id, "--memory", 2048, "--cpus", "2"]
            vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
        end

        local.vm.network "private_network", ip: "192.168.100.80"

        # If true, then any SSH connections made will enable agent forwarding.
        # Default value: false
        # config.ssh.forward_agent = true
        local.vm.network :forwarded_port, guest: 22, host: 3333, id: "ssh", disabled: true
        local.vm.network :forwarded_port, guest: 22, host: 3340, auto_correct: true

        local.vm.synced_folder ".", "/var/www/Synapse/", id:"vagrant-root", type: "nfs", mount_options: ["nolock,vers=3,udp,noatime,actimeo=1"]
    end

    # Update the server
    config.vm.provision "shell", inline: "apt-get update --fix-missing"

    # Set the Timezone to something useful
    config.vm.provision "shell", inline: "echo \"Europe/Paris\" | sudo tee /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata"

    config.vm.provision :ansible do |ansible|
        ansible.playbook = "ansible/provisioning.yml"
        ansible.limit = "all"
    end

end

# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

# Forwarded files builder
def get_forwarded_files_from_parameters(forwarded_files_from_home)
    forwarded_files = []
    if !forwarded_files_from_home.instance_of?(Array)
        return forwarded_files
    end

    # Retrieve main user information on VM side
    ansible_local_variables = YAML.load_file('ansible/vars.local.yml') || {}
    ansible_variables = YAML.load_file('ansible/vars.yml') || {}
    vm_user_user = ansible_local_variables['main_user'].instance_of?(String) ? ansible_local_variables['main_user']
        : ansible_variables['main_user'].instance_of?(String) ? ansible_variables['main_user']
        : 'vagrant'
    vm_user_group = ansible_local_variables['main_group'].instance_of?(String) ? ansible_local_variables['main_group']
        : ansible_variables['main_group'].instance_of?(String) ? ansible_variables['main_group']
        : 'vagrant'
    vm_user_home_dir = ansible_local_variables['main_user_home_dir'].instance_of?(String) ? ansible_local_variables['main_user_home_dir']
        : ansible_variables['main_user_home_dir'].instance_of?(String) ? ansible_variables['main_user_home_dir']
        : '/home/vagrant'

    forwarded_files_from_home.each do |forwarded_file|
        forwarded_file_full_path = File.join(Dir.home, forwarded_file)
        if !File.exists?(forwarded_file_full_path)
            puts("\"forwarded_files_from_home\" vagrant parameter contains a file which does not exist: [#{forwarded_file_full_path}]")
            exit!(1)
        end
        forwarded_files.push({
            'user' => vm_user_user,
            'group' => vm_user_group,
            'source_path' => forwarded_file_full_path,
            'destination_temporary_path' => File.join('/tmp/forwarded_files', forwarded_file),
            'user_destination_path' => File.join(vm_user_home_dir, forwarded_file),
            'root_destination_path' => File.join('/root', forwarded_file),
        })
    end

    return forwarded_files
end

# Vagrant minimum version
Vagrant.require_version '>= 1.8.4'

# Windows requirements
if Vagrant::Util::Platform.windows?

    # Plugin "vagrant-winnfsd"
    if !Vagrant.has_plugin?('vagrant-winnfsd')
        puts('The "vagrant-winnfsd" plugin is required on Windows. Please type: vagrant plugin install vagrant-winnfsd')
        exit!(1)
    end

end

# Create personal "ansible/*.dist" files copy
Dir.glob('ansible/*.dist') do |dist_file|
    personal_file = File.join(File.dirname(dist_file), File.basename(dist_file, File.extname(dist_file)))
    if !File.file?(personal_file)
        FileUtils.cp(dist_file, personal_file)
        puts("Your personal file [#{personal_file}] has been copied from [#{dist_file}]")
    end
end

# Merge "ansible/vagrant-parameters.yml" with default parameters values
file_parameters = YAML.load_file('ansible/vagrant-parameters.yml') || {}
parameters = {
    'vm_memory' => file_parameters['vm_memory'].instance_of?(Integer) ? file_parameters['vm_memory'] : 2048,
    'vm_cpus' => file_parameters['vm_cpus'].instance_of?(Integer) ? file_parameters['vm_cpus'] : 2,
    'vm_ip' => file_parameters['vm_ip'].instance_of?(String) ? file_parameters['vm_ip'] : '192.168.100.10',
    'vm_ip_aliases' => file_parameters['vm_ip_aliases'].instance_of?(Array) ? file_parameters['vm_ip_aliases'] : [],
    'vm_hostname' => file_parameters['vm_hostname'].instance_of?(String) ? file_parameters['vm_hostname'] : 'majora-ansible-vagrant',
    'sharing_strategy' => ['self', 'subdirectory'].include?(file_parameters['sharing_strategy']) ? file_parameters['sharing_strategy'] : 'self',
    'sharing_self_absolute_path_in_vm' => file_parameters['sharing_self_absolute_path_in_vm'].instance_of?(String) ? file_parameters['sharing_self_absolute_path_in_vm'] : '/var/www/majora-ansible-vagrant',
    'sharing_subdirectory_relative_path' => file_parameters['sharing_subdirectory_relative_path'].instance_of?(String) ? file_parameters['sharing_subdirectory_relative_path'] : 'www',
    'sharing_subdirectory_absolute_path_in_vm' => file_parameters['sharing_subdirectory_absolute_path_in_vm'].instance_of?(String) ? file_parameters['sharing_subdirectory_absolute_path_in_vm'] : '/var/www',
    'forwarded_files' => get_forwarded_files_from_parameters(file_parameters['forwarded_files_from_home']),
    'install_ansible_roles' => [true, false].include?(file_parameters['install_ansible_roles']) ? file_parameters['install_ansible_roles'] : true,
}

# VMs configuration
Vagrant.configure(2) do |config|

    # Plugin "vagrant-hostmanager" configuration
    if Vagrant.has_plugin?('vagrant-hostmanager')
        config.hostmanager.enabled = false
        config.hostmanager.manage_host = true
        config.hostmanager.manage_guest = false
        config.hostmanager.include_offline = true
        config.hostmanager.aliases = parameters['vm_ip_aliases']
    else
        puts('The "vagrant-hostmanager" plugin is not installed.')
        puts('It means that you will have to add the following lines to your "/etc/hosts" file yourself:')
        puts("#{parameters['vm_ip']} #{parameters['vm_hostname']}")
        parameters['vm_ip_aliases'].each do |host|
            puts("#{parameters['vm_ip']} #{host}")
        end
    end

    # Main VM configuration
    config.vm.define :local, primary: true do |local|

        # Ubuntu version
        local.vm.box = 'ubuntu/trusty64'

        # VirtualBox configuration
        local.vm.provider 'virtualbox' do |vb|
            vb.customize ['modifyvm', :id, '--memory', parameters['vm_memory'], '--cpus', parameters['vm_cpus']]
            vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on', '--natdnsproxy1', 'on', '--usb', 'off']
            vb.customize ['setextradata', :id, 'VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root', '1']
        end

        # Network
        local.vm.hostname = parameters['vm_hostname']
        local.vm.network 'private_network', ip: parameters['vm_ip']

        # Shared folders
        if parameters['sharing_strategy'] == 'subdirectory'
            local.vm.synced_folder 'ansible', '/ansible/', id:'provisioning', type: 'nfs', mount_options: ['nolock,vers=3,udp,noatime,actimeo=1']
            local.vm.synced_folder parameters['sharing_subdirectory_relative_path'], parameters['sharing_subdirectory_absolute_path_in_vm'], id:'subdirectory', type: 'nfs', mount_options: ['nolock,vers=3,udp,noatime,actimeo=1']
        else
            local.vm.synced_folder '.', parameters['sharing_self_absolute_path_in_vm'], id:'self', type: 'nfs', mount_options: ['nolock,vers=3,udp,noatime,actimeo=1']
        end

        # Ansible provisioning
        local.vm.provision 'ansible', type: 'ansible_local' do |ansible|
            ansible.install_mode = :pip
            ansible.version = '2.2.0.0'
            ansible.galaxy_command = parameters['install_ansible_roles'] ? 'sudo apt-get install -y git && ansible-galaxy install --force -p . --role-file=galaxy-majora.yml && ansible-galaxy install --force -p roles --role-file=galaxy-additionals.yml' : ''
            ansible.galaxy_role_file = 'galaxy-majora.yml'
            ansible.provisioning_path = parameters['sharing_strategy'] == 'subdirectory' ? '/ansible' : File.join(parameters['sharing_self_absolute_path_in_vm'], 'ansible')
            ansible.playbook = 'app.yml'
        end

        # Forwarded files provisioning
        parameters['forwarded_files'].each do |forwarded_file|
            local.vm.provision "begin forwarding #{forwarded_file['source_path']}", type: 'file', run: 'always' do |file|
                file.source = forwarded_file['source_path']
                file.destination = forwarded_file['destination_temporary_path']
            end
            local.vm.provision "finish forwarding #{forwarded_file['source_path']}", type: 'shell', run: 'always' do |s|
                s.inline = "mkdir -p #{File.dirname(forwarded_file['root_destination_path'])} #{File.dirname(forwarded_file['user_destination_path'])} && " +
                    "cp -rf #{forwarded_file['destination_temporary_path']} #{forwarded_file['root_destination_path']} && " +
                    "cp -rf #{forwarded_file['destination_temporary_path']} #{forwarded_file['user_destination_path']} && " +
                    "chown -R #{forwarded_file['user']}:#{forwarded_file['group']} #{forwarded_file['user_destination_path']} && " +
                    "chmod -R 700 #{forwarded_file['root_destination_path']} #{forwarded_file['user_destination_path']}"
            end
        end

        # Plugin "vagrant-hostmanager" provisioning
        if Vagrant.has_plugin?('vagrant-hostmanager')
            local.vm.provision :hostmanager
        end

    end

end

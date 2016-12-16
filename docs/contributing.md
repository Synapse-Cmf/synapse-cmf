## Contributing

Synapse Cmf project is open for contribution, section below explains how to install your dev environment.

### Vagrant install (MacOS)

First, get Homebrew, Vagrant and Ansible :

* Homebrew : http://brew.sh/
* Ansible : https://valdhaus.co/writings/ansible-mac-osx/
* Vagrant : http://docs.vagrantup.com/v2/getting-started/index.html.

#### Project copy and vm provisioning

```bash
cd your/workspace
git clone git@github.com:synapse-cmf/synapse-cmf
cd synapse-cmf
make vm-provision        # could be (very) long
make init
```

Edit your hostfile (/etc/hosts) :
```
### Synapse ###
192.168.100.80  demo.synapse.dev
192.168.100.80  demo.admin-synapse.dev
```

### Project build

```bash
vagrant ssh
make install build
```

### Project tests
```bash
make tests
```

### Pull request
After push, feel free to open a [pull request](https://github.com/LinkValue/MajoraFrameworkExtraBundle/compare) on the main repository !

Synapse - Dev environment
=========================

## Install (MacOs)

First, get Homebrew, Vagrant and Ansible :

* Homebrew : http://brew.sh/
* Ansible : https://valdhaus.co/writings/ansible-mac-osx/
* Vagrant : http://docs.vagrantup.com/v2/getting-started/index.html.

### Project copy and vm provisioning

```bash
cd your/workspace
git clone git@github.com:LinkValue/MotionFrance.git Synapse-dev
cd Synapse-dev
make init        # could be (very) long
```

Edit your hostfile (/etc/hosts) :
```
### Synapse ###
192.168.100.80  demo.synapse.dev
192.168.100.80  demo.admin-synapse.dev
192.168.100.80  lyon.ccir.dev
192.168.100.80  grenoble.ccir.dev
192.168.100.80  lyon.admin-ccir.dev
192.168.100.80  grenoble.admin-ccir.dev
192.168.100.80  motion.dev
192.168.100.80  admin-motion.dev
```

### Project building

```bash
vagrant ssh
make install build
```

## Distributions

* Demo ([front](http://demo.synapse.dev/demo_dev.php/) / [admin](http://demo.admin-synapse.dev/demo_dev.php/)). 
* Ccir ([front](http://lyon.ccir.dev/ccir_dev.php/) / [admin](http://lyon.admin-ccir.dev/ccir_dev.php/)). 
* Motion ([front](http://motion.dev/motion_dev.php/) / [admin](http://admin-motion.dev/motion_dev.php/)). 

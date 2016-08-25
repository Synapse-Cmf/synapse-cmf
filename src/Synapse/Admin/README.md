SynapseAdminBundle
==================

Synapse Cmf distribution which provide base Cmf kernel classes (through [SynapseCmfBundle](https://github.com/Synapse-Cmf/SynapseCmfBundle) requirement), and a internal features admin like :

 - Skeletons admin
 - Photo module admin
 - a basic Bootstrap based admin theme 

If you need more Synapse features, consider to use these distributions :

  - [SynapsePageBundle](https://github.com/synapse-cmf/SynapsePageBundle) to get "page" content type implementation
  - [SynapseDemoBundle](https://github.com/synapse-cmf/SynapseDemoBundle) to get a simple Boostrap theme for "page" content type

## Installation

Register bundle version (standard semver is used) :
```json
// composer.json
{
    "require": {
        // ....
        "synapse-cmf/synapse-admin-bundle": "~1.0"
    }
}
```

Then, register the bundle, be careful to also register all dependencies :
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
        new Symfony\Bundle\TwigBundle\TwigBundle(),
        new Symfony\Bundle\MonologBundle\MonologBundle(),
        new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
        new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        new Majora\Bundle\FrameworkExtraBundle\MajoraFrameworkExtraBundle($this),
        new Synapse\Cmf\Bundle\SynapseCmfBundle(),
        new Synapse\Admin\Bundle\SynapseAdminBundle(),
    );
}
```

For complete configuration reference, please refer to [main repository documentation](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/README.md).

## Resources

  - [Synapse Cmf documentation](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/README.md)
  - [Contributing](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/docs/contributing.md)
  - [Report issues](https://github.com/Synapse-Cmf/synapse-cmf/issues) and send [Pull Requests](https://github.com/Synapse-Cmf/synapse-cmf/pulls) in the main [Synapse-Cmf repository](https://github.com/Synapse-Cmf/synapse-cmf)

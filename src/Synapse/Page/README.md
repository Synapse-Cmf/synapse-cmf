SynapsePageBundle
==================

Synapse Cmf distribution which provides :
  
  - base Cmf kernel classes (through [SynapseCmfBundle](https://github.com/synapse-cmf/SynapseCmfBundle) requirement)
  - internal features admin (through [SynapseAdminBundle](https://github.com/synapse-cmf/SynapseAdminBundle) requirement)
  - page content type
  - page admin
  - default page front controller

If you need a full featured Synapse Cmf, consider to use [SynapseDemoBundle](https://github.com/synapse-cmf/SynapseDemoBundle) to get a simple Boostrap theme for page content type, or directly [main distribution](https://github.com/synapse-cmf/synapse-cmf).

## Installation

Register bundle version (standard semver is used) :
```json
// composer.json
{
    "require": {
        // ....
        "synapse-cmf/synapse-page-bundle": "~1.0"
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
        new Synapse\Page\Bundle\SynapsePageBundle(),
    );
}
```

For complete configuration reference, please refer to [main repository documentation](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/README.md).

## Resources

  - [Synapse Cmf documentation](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/README.md)
  - [Contributing](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/docs/contributing.md)
  - [Report issues](https://github.com/Synapse-Cmf/synapse-cmf/issues) and send [Pull Requests](https://github.com/synapse-cmf/synapse-cmf/pulls) in the main [Synapse-Cmf repository](https://github.com/synapse-cmf/synapse-cmf)

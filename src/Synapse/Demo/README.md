SynapseDemoBundle
=================

Simple application and theme for a Synapse application using SynapsePageBundle.
This bundle purpose is to give an exemple of project architecture using Synapse Cmf, and to test built-in features.

_*Warning*_ : This bundle shouldn't be used into your own project except in dev environment to test Synapse-Cmf features.

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
        new Synapse\Demo\Bundle\ThemeBundle\SynapseDemoThemeBundle(),
        new Synapse\Demo\Bundle\AppBundle\SynapseDemoAppBundle(),
    );
}
```

For complete configuration reference, please refer to [main repository documentation](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/README.md).

## Resources

  - [Synapse Cmf documentation](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/README.md)
  - [Contributing](https://github.com/Synapse-Cmf/synapse-cmf/blob/v1.0/docs/contributing.md)
  - [Report issues](https://github.com/Synapse-Cmf/synapse-cmf/issues) and send [Pull Requests](https://github.com/synapse-cmf/synapse-cmf/pulls) in the main [Synapse-Cmf repository](https://github.com/synapse-cmf/synapse-cmf)

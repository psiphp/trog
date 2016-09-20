Trog CMS
========

Trog ([Troglodyte](https://en.wikipedia.org/wiki/Caveman)) is an experimental
CMS built by the
[Psi](https://github.com/psiphp) organization as a way of driving forward the
development of decoupled CMS components.

The Trog CMS aims to offer entry-level content management features, initial
CMS target features include:

- Browsing resources ([ResourceBrowser](https://github.com/psiphp/resource-browser))
- Content type definition ([ContentType](https://github.com/psiphp/content-type))
- Workflow management (via. Symfony [Workflow component](https://symfony.com/doc/master/components/workflow.html)

Storage
-------

Will Doctrine ORM (for storing users) and Doctrine
[PHPCR-ODM](https://github.com/doctrine/phpcr-odm) for storing content.

Sylius E-Commerce Integration
-----------------------------

Trog development has been influenced by [Sylius](https://sylius.org) and will be able to seamlessly
integrate with it, as both Trog and Sylius use Symfony full-stack and the
Semantic UI CSS framework.

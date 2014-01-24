Installation
============

Hitch comes bundled as a
`package <https://packagist.org/packages/clarkf/hitch>`_ in the `Packagist`_
repository.

Ensure that you have setup composer, and add ``clarkf/hitch`` to your
``composer.json`` file:

.. code-block:: javascript

    {
        "require": {
            "clarkf/hitch": "@dev-master"
        }
    }

**Be careful**, Hitch has not yet been fully released, and as such, does
not have any tagged versions within Packagist.  By requiring
``@dev-master``, you will get the most current version from the `Github
Repository`_. Be sure to verify the `build status`_ before including it
in your project!

.. image:: https://travis-ci.org/clarkf/hitch.png?branch=master
  :target: https://travis-ci.org/clarkf/hitch


.. _Packagist: https://packagist.org/
.. _Github Repository: https://github.com/clarkf/hitch
.. _build status: https://travis-ci.org/clarkf/hitch

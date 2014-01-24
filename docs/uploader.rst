The Uploader
============

The Uploader is the core of Hitch.  It directs your application how and
where to store files.  Simply define an uploader by extending
``Hitch\Uploader``.

.. code-block:: php

   class MyUploader extends \Hitch\Uploader {}

The most important method provided by an uploader is its ``store()``
method.  Simply provide a ``File`` object, and Hitch will take care of
the rest:

.. code-block:: php

   public function controllerAction()
   {
        $file = $this->getRequest()->getFile('file');

        $uploader = new MyUploader();

        $uploader->store($file);
   }

Storage Adapters
----------------

The uploader passes the files that it generates off to *Storage
Adapters*.  You can specify which storage adapters to use by overriding
the uploader's ``getStorageAdapters()`` method:

.. literalinclude:: examples/getstorageadapters.php
   :language: php


File Storage Adapter
^^^^^^^^^^^^^^^^^^^^

``Hitch\Storage\File`` provides a means to store a file on the local
filesystem. It's also the default storage adapter. Simply pass the *root
upload directory* as the constructor, and your files will be stored:

.. code-block:: php

   new \Hitch\Storage\File($root . "/public/images/");


Version Descriptions
--------------------

Hitch will automatically generate different versions of each uploaded
files for you.  You must describe each version that you require:

.. literalinclude:: examples/versiondescriptions.php
   :language: php


``resize`` process
^^^^^^^^^^^^^^^^^^
resize an image to *exactly* the supplied dimensions


.. code-block:: php

    "resize" => array(100, 100)

.. image:: media/original.jpg

becomes

.. image:: media/resize.100x100.jpg

``resizeKeepAspect`` process
^^^^^^^^^^^^^^^^^^

Resize an image while maintaining its aspect ratio.


.. code-block:: php

    "resizeKeepAspect" => array(100, 100)

.. image:: media/original.jpg

becomes

.. image:: media/resizeKeepAspect.100x100.jpg

Available processes:

* ``resizeKeepAspect($width, $height)`` - Resize the image to the
  specified size, while keeping the aspect ratio

File Naming
-----------

You may specify how your files are named by overriding ``getFilename()``
and ``getVersionPath()``:

.. literalinclude:: examples/filenames.php
   :language: php

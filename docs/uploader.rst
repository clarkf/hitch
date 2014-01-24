The Uploader
============

Storage Adapters
----------------

The uploader passes the files that it generates off to *Storage
Adapters*.  You can specify which storage adapters to use by overriding
the uploader's ``getStorageAdapters()`` method:

.. literalinclude:: examples/getstorageadapters.php
   :language: php

Available storage adapters:

* ``Hitch\Storage\File`` - Store files to the local filesystem.

Version Descriptions
--------------------

Hitch will automatically generate different versions of each uploaded
files for you.  You must describe each version that you require:

.. literalinclude:: examples/versiondescriptions.php
   :language: php

Available processes:

* ``resize($width, $height)`` - Resizes the image
* ``resizeKeepAspect($width, $height)`` - Resize the image to the
  specified size, while keeping the aspect ratio

File Naming
-----------

You may specify how your files are named by overriding ``getFilename()``
and ``getVersionPath()``:

.. literalinclude:: examples/filenames.php
   :language: php

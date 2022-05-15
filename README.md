## What is this repo all about?

This repo contains three examples of chunked file upload w/ PHP and Dropzone.
It's a simplified version of this [SO answer](https://stackoverflow.com/questions/56156402/how-to-concatenate-chunked-file-uploads-from-dropzone-js-with-php)


## What do examples do?

`index.html` is the most common way to use Dropzone.
* files are automatically uploaded as they are dropped onto the Dropzone
* previews are generated in the Dropzone vs a standalone preview element

`index2.html` disables automatic uploads and shows an example of how to manually trigger uploads w/
`processQueue`

`index3.html` demonstrates how to use a separate preview element.
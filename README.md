# Media 

News Player Element.

## Features

- embed local video/audio (like ContentMedia)
- embed external video/audio
- autoplay
- individual preview image
- custom templates (choose on newslist, newsarchive or newsreader)
- custom preview image (choose on newslist or newsarchive)

## Template Code

```
<?php if ($this->addMedia): ?>
	<?php echo $this->mediaPlayer; ?>
<?php endif; ?>
```

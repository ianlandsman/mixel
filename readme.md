# Mixel

## Simple Mixpanel metric tracking library.

This library utilizes the [Guzzle](https://github.com/guzzle/guzzle) PHP library to perform HTTP requests.

## Usage

```
$tracker = new Otwell\Mixel\Tracker('your-mixpanel-token');

$tracker->track('event-name', ['foo' => 'bar', 'baz' => 'boom']);
```
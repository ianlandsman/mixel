<?php namespace Otwell\Mixel;

use Guzzle\Http\Client;

class Tracker {

	/**
	 * The Mixpanel token used by the tracker.
	 *
	 * @var string
	 */
	protected $token;

	/**
	 * The Guzzle HTTP client instance.
	 *
	 * @var \Guzzle\Http\Client
	 */
	protected $client;

	/**
	 * Create a new Mixpanel tracker instance.
	 *
	 * @param  string  $token
	 * @param  \Guzzle\Http\Client  $client
	 * @return void
	 */
	public function __construct($token, Client $client = null)
	{
		$this->token = $token;

		$this->client = $client ?: new Client('http://api.mixpanel.com');
	}

	/**
	 * Track an event in Mixpanel.
	 *
	 * @param  string  $event
	 * @param  array   $data
	 * @param  string  $token
	 * @return void
	 */
	public function track($event, array $properties = array(), $token = null)
	{
		$payload = $this->createPayload($event, $properties, $token);

		$this->client->get('/track/?data='.base64_encode(json_encode($payload)))->send();
	}

	/**
	 * Create the payload array for the Mixpanel request.
	 *
	 * @param  string  $event
	 * @param  array   $properties
	 * @param  string  $token
	 * @return array
	 */
	protected function createPayload($event, array $properties, $token)
	{
		$payload = compact('event', 'properties');

		$payload['properties']['token'] = $token ?: $this->token;

		return $payload;
	}

}

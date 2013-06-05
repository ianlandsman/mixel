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
		$payload = compact('event', 'properties');

		$payload['properties']['token'] = $token ?: $this->token;

		$this->client->get('/track/?data='.base64_encode(json_encode($payload)))->send();
	}

	/**
	 * Track an engagement in Mixpanel.
	 *
	 * @param  string  $type
	 * @param  array   $properties
	 * @param  string  $distinctId
	 * @param  string  $clientId
	 * @return void
	 */
	public function engage($type, array $properties, $distinctId, $clientIp, $token = null)
	{
		$payload = array(
			'$'.$type => $properties,
			'$token' => $token ?: $this->token,
			'$distinct_id' => $distinctId,
			'$ip' => $clientIp
		);

		$this->client->get('/engage/?data='.base64_decode(json_encode($payload)))->send();
	}

}

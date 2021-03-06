<?php


namespace Edysanchez\Mathtrade\Infrastructure\Persistence\XmlApi;

use Exception;
use Guzzle\Http\Client;


class BoardGameGeekXmlApiService
{

    public function findTradeableByUsername($username) {
        return $this->queryTradeablesByUsername($username);

    }
    /**
     * @param $xml
     * @throws Exception
     */
    protected function guardFromApiError($xml)
    {
        if ($xml->error) {
            throw new \Exception('Error ');
        }
    }

    /**
     * @param $queryResponse
     * @throws Exception
     */
    protected function guardFromHTTPError($queryResponse)
    {
        if ($queryResponse->getStatusCode() >= 400) {
            throw new \Exception('Api Error');
        }
    }

    /**
     * @param $queryResponse
     * @param $queryRequest
     * @return mixed
     */
    protected function tryToRepeatIfWaitReply($queryResponse, $queryRequest)
    {
        if ($queryResponse->getStatusCode() === 202) {
            $queryResponse = $queryRequest->send();
            return $queryResponse;
        }
        return $queryResponse;
    }
    /**
     * @return mixed
     * @throws Exception
     */
    protected function queryTradeablesByUsername($username)
    {
        $bggClient = new Client();

        $queryRequest = $bggClient->get($this->getTradeableQueryUrlByUsername($username));
        $queryResponse = $queryRequest->send();

        $this->guardFromHTTPError($queryResponse);

        $queryResponse = $this->tryToRepeatIfWaitReply($queryResponse, $queryRequest);

        $this->guardFromHTTPError($queryResponse);
        $xml = $queryResponse->xml();

        $this->guardFromApiError($xml);
        return $xml->children();
    }

    /**
     * @param $username
     * @return string
     */
    private function getTradeableQueryUrlByUsername($username)
    {
        return 'http://boardgamegeek.com/xmlapi2/collection?username=' . $username . '&trade=1';
    }
}
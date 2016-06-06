<?php


class ApiControllerTest extends TestCase
{
    public function testSeasonEndpoint()
    {
        $client = new \App\Library\HaloClient('seasons', 0);
        $data = $client->request();

        $this->assertTrue(is_array($data) && isset($data['error']) && $data['error'] == false);
    }

    public function testCsrEndpoint()
    {
        $client = new \App\Library\HaloClient('csrs', 0);
        $data = $client->request();

        $this->assertTrue(is_array($data) && isset($data['error']) && $data['error'] == false);
    }

    public function testPreseasonPlaylist()
    {
        $client = new \App\Library\HaloClient('leaderboard/2041d318-dd22-47c2-a487-2818ecf14e41/c98949ae-60a8-43dc-85d7-0feb0b92e719', 0);
        $data = $client->request();

        $this->assertTrue(is_array($data) && isset($data['error']) && $data['error'] == false);
        $this->assertTrue(count($data['leaderboard']) == 250);
    }
}

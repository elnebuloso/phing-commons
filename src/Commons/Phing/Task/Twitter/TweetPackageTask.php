<?php
namespace Commons\Phing\Task\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Class TweetPackageTask
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class TweetPackageTask extends \Task
{
    /**
     * @var string
     */
    private $projectUrl;

    /**
     * @var string
     */
    private $projectTags;

    /**
     * @param string $projectUrl
     */
    public function setProjectUrl($projectUrl)
    {
        $this->projectUrl = trim($projectUrl);
    }

    /**
     * @param string $projectTags
     */
    public function setProjectTags($projectTags)
    {
        $this->projectTags = trim($projectTags);
    }

    /**
     * @return void
     * @throws \BuildException
     */
    public function main()
    {
        $twitterConsumerKey = $this->getProjectProperty('twitter.consumer.key');
        $twitterConsumerSecret = $this->getProjectProperty('twitter.consumer.secret');

        $twitterAccessToken = $this->getProjectProperty('twitter.access.token');
        $twitterAccessTokenSecret = $this->getProjectProperty('twitter.access.token.secret');

        $projectVersion = $this->getProjectProperty('project.version');
        $projectVendor = $this->getProjectProperty('project.vendor');
        $projectName = $this->getProjectProperty('project.name');

        $tweet = "{$projectVendor}/{$projectName} {$projectVersion}";

        if (!empty($this->projectUrl)) {
            $tweet .= ' | ' . $this->projectUrl;
        }

        if (!empty($this->projectTags)) {
            $tweet .= ' | #' . implode(", #", array_filter(array_map("trim", explode(",", $this->projectTags))));
        }

        $this->log('this tweet will be sent');
        $this->log($tweet);

        try {
            $request = new \InputRequest('do you wanna send this tweet? [y/n]:');
            $this->project->getInputHandler()->handleInput($request);
            $answer = trim($request->getInput());
        } catch (\IOException $e) {
            throw new \BuildException("prompt failed. reason: " . $e->getMessage());
        }

        $answer = empty($answer) ? 'n' : substr(strtolower($answer), 0, 1);

        if ($answer == 'n') {
            $this->log('skipped tweeting to twitter');

            return;
        }

        $this->log('tweet sending ...');

        try {
            $connection = new TwitterOAuth($twitterConsumerKey, $twitterConsumerSecret, $twitterAccessToken, $twitterAccessTokenSecret);
            $connection->post("statuses/update", array("status" => $tweet));
        } catch (\Exception $e) {
            throw new \BuildException("sending failed. reason: " . $e->getMessage());
        }

        $this->log('tweet was send');
    }

    /**
     * @param string $name
     * @return string
     * @throws \BuildException
     */
    protected function getProjectProperty($name)
    {
        $value = trim($this->getProject()->getProperty($name));

        if (empty($value)) {
            throw new \BuildException("missing property {$name}");
        }

        return $value;
    }
}
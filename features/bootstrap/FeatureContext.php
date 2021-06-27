<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Demo\Models\Rota;
use Demo\Models\Shift;
use Demo\Models\Shop;
use Demo\Models\Staff;
use Demo\Services\SingleManning\Calculator;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private Shop $shop;
    private Rota $rota;
    private DateTimeZone $timezone;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->timezone = new DateTimeZone(date_default_timezone_get());
    }

    /**
     * @Given staff are working at the :shop
     */
    public function staffAreWorkingAtThe(string $shop,): void
    {
        $this->shop = new Shop($shop);
    }

    /**
     * @Given we are looking at the current working week
     */
    public function weAreLookingAtTheCurrentWorkingWeek(): void
    {
        //Start on Monday of the Current Week
        $this->rota = new Rota(
            (new DateTime(timezone: $this->timezone))->modify('monday this week'),
            $this->shop,
        );
    }

    /**
     * @Given :worker_name is working on :day starting at :start and ending at :end
     */
    public function isWorkingAtOnStartingAtEndingAt(
        string $worker_name,
        string $day,
        int $start,
        int $end
    ): void {
        
        $staff = new Staff(
            first_name: $worker_name,
            last_name: 'User',
            shop: $this->shop,
        );
    
        new Shift(
            rota: $this->rota,
            staff: $staff,
            start_time: (new DateTime(timezone: $this->timezone))->modify("$day this week +$start hour"),
            end_time: (new DateTime(timezone: $this->timezone))->modify("$day this week +$end hour"),
        );
    }

    /**
     * @When no-one else works during the day
     */
    public function noOneElseWorksDuringTheDay(): void
    {
        //Do Nothing
    }

    /**
     * phpcs:ignore Generic.Files.LineLength.TooLong
     * @Then :worker_name receives single manning supplement for the whole duration of their shift for :day, :supplement minutes.
     */
    public function receivesSingleManningSupplementForTheWholeDurationOfTheirShift(
        string $worker_name,
        string $day,
        int $supplement,
    ): void {
        $this->receivesSingleManningSupplementForAPortionOfTheirShiftMinutes($worker_name, $day, $supplement);
    }

    /**
     * @Then :worker_name receives no single manning supplement for their shift for :day
     */
    public function receivesNoSingleManningSupplementForTheirShift(
        string $worker_name,
        string $day,
    ): void {
        $this->receivesSingleManningSupplementForAPortionOfTheirShiftMinutes($worker_name, $day, 0);
    }

    /**
     * @Then :worker_name receives single manning supplement for a portion of their shift for :day, :supplement minutes.
     */
    public function receivesSingleManningSupplementForAPortionOfTheirShiftMinutes(
        string $worker_name,
        string $day,
        int $supplement,
    ): void {

        $single_manning = (new Calculator())->getSingleManningData($this->rota);
        $date = (new DateTime(timezone: $this->timezone))->modify("$day this week")->format('Y-m-d');
        
        Assert::assertEquals(
            $single_manning->weekly_breakdown[$date][$worker_name],
            $supplement
        );
    }
}

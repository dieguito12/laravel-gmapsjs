<?php


use App\Models\Business;
use App\Repositories\BusinessRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessRepositoryTest extends TestCase{

    use DatabaseTransactions;

    /*
    * Initialize the testing enviroment
    */
    public function setUp()
    {
        parent::setUp();
        $this->app->make('db')->beginTransaction();
    }

    /**
    * Do a rollback of the database
    */
    public function tearDown(){
        $this->app->make('db')->rollBack();
        parent::tearDown();
    }

    /**
     * @test add new business
     */
    public function tests_adding_new_business_in_repository()
    {
        $business = array('name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);
        $createdBusiness = BusinessRepository::create($business);
        $this->assertArrayHasKey('id', $createdBusiness);
        $this->assertNotNull($createdBusiness['id'], 'Created Business must have id specified');
        $this->assertNotNull(Business::find($createdBusiness['id']), 'Business with given id must be in DB');
    }

    /**
     * @test edit not existing business
     */
    public function tests_trying_edit_not_existing_business_in_repository()
    {
        $business = array('id' => 9999999999,
                          'name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);
        $response = BusinessRepository::update($business, $business['id']);
        $this->assertFalse($response);
    }

    /**
     * @test edit existing business
     */
    public function tests_editting_existing_business_in_repository()
    {
        $business = array('name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);
        $createdBusiness = BusinessRepository::create($business);

        $createdBusiness['name'] = 'Fight Training Academy';
        $response = BusinessRepository::update($createdBusiness, $createdBusiness['id']);
        $this->assertEquals($response['name'], $createdBusiness['name']);
        $this->assertEquals($response['description'], $createdBusiness['description']);
        $this->assertEquals($response['id'], $createdBusiness['id']);
        $this->assertEquals($response['lat'], $createdBusiness['lat']);
        $this->assertEquals($response['long'], $createdBusiness['long']);
    }

    /**
     * @test gets existing business
     */
    public function tests_getting_detail_existing_business_in_repository()
    {
        $business = array('name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);
        $createdBusiness = BusinessRepository::create($business);

        $response = BusinessRepository::findById($createdBusiness['id']);
        $this->assertEquals($response['name'], $createdBusiness['name']);
        $this->assertEquals($response['description'], $createdBusiness['description']);
        $this->assertEquals($response['id'], $createdBusiness['id']);
        $this->assertEquals($response['lat'], $createdBusiness['lat']);
        $this->assertEquals($response['long'], $createdBusiness['long']);
    }

    /**
     * @test gets not existing business
     */
    public function tests_getting_detail_not_existing_business_in_repository()
    {
        $business = array('id' => 9999999999,
                          'name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);

        $response = BusinessRepository::findById($business['id']);
        $this->assertFalse($response);
    }

    /**
     * @test gets list of businesses
     */
    public function tests_getting_list_business_in_repository()
    {
        $count = count(Business::all());

        $business1 = array('name' => 'FTA1',
                          'description' => 'Fight Training Academy 1',
                          'lat' => -69.3453,
                          'long' => 80.99384);

        $business2 = array('name' => 'FTA2',
                          'description' => 'Fight Training Academy 2',
                          'lat' => -69.324,
                          'long' => 80.493);

        $createdBusiness1 = BusinessRepository::create($business1);
        $createdBusiness2 = BusinessRepository::create($business2);

        $response = BusinessRepository::getAll();
        $this->assertCount($count + 2, $response);
    }

}

<?php


use App\Models\Business;
use App\Http\Controllers\BusinessController;
use App\Repositories\BusinessRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class ControllerTest extends TestCase{

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
    public function tests_adding_new_business()
    {
        $businessRequest = array();
        $businessRequest['name'] = 'FTA';
        $businessRequest['description'] = 'Fight Training Academy';
        $businessRequest['lat'] = -69.3453;
        $businessRequest['long'] = 80.99384;

        $response = $this->action('POST','BusinessController@store', array(), $businessRequest, array(), array(), array());
        $this->assertSessionHas('flash_notification.message','Business saved successfully.');
        $this->assertRedirectedToAction('BusinessController@index');
    }

    /**
     * @test add new without data business
     */
    public function tests_trying_add_business_without_data()
    {
        $businessRequest = array();
        $businessRequest['name'] = '';
        $businessRequest['description'] = 'Fight Training Academy';
        $businessRequest['lat'] = -69.3453;
        $businessRequest['long'] = 80.99384;

        $response = $this->action('POST','BusinessController@store', array(), $businessRequest, array(), array(), array());
        $this->assertSessionHas('flash_notification.message','The business must have a name.');
        $this->assertRedirectedToAction('BusinessController@create');
    }

    /**
     * @test edit not existing business
     */
    public function tests_trying_edit_not_existing_business()
    {
        $businessRequest = array();
        $businessRequest['id'] = 9999999999;
        $businessRequest['name'] = 'FTA';
        $businessRequest['description'] = 'Fight Training Academy';
        $businessRequest['lat'] = -69.3453;
        $businessRequest['long'] = 80.99384;

        $response = $this->action('PATCH','BusinessController@update', array($businessRequest['id']), $businessRequest, array(), array(), array());
        $this->assertSessionHas('flash_notification.message','Business not found');
        $this->assertRedirectedToAction('BusinessController@index');
    }

    /**
     * @test edit business without data
     */
    public function tests_trying_edit_business_without_data()
    {
        $businessRequest = array();
        $businessRequest['name'] = 'FTA';
        $businessRequest['description'] = 'Fight Training Academy';
        $businessRequest['lat'] = -69.3453;
        $businessRequest['long'] = 80.99384;

        $createdBusiness = BusinessRepository::create($businessRequest);

        $createdBusiness['name'] = '';

        $response = $this->action('PATCH','BusinessController@update', array($createdBusiness['id']), $createdBusiness, array(), array(), array());
        $this->assertSessionHas('flash_notification.message','The business must have a name.');
        $this->assertRedirectedToAction('BusinessController@edit',['businesses' => $createdBusiness['id']]);
    }

    /**
     * @test edit existing business
     */
    public function tests_editting_existing_business()
    {
        $businessRequest = array();
        $businessRequest['name'] = 'FTA';
        $businessRequest['description'] = 'Fight Training Academy';
        $businessRequest['lat'] = -69.3453;
        $businessRequest['long'] = 80.99384;

        $createdBusiness = BusinessRepository::create($businessRequest);

        $createdBusiness['name'] = 'Fight Training Academy Name';
        $response = $this->action('PATCH','BusinessController@update', array($createdBusiness['id']), $createdBusiness, array(), array(), array());
        
        $this->assertSessionHas('flash_notification.message','Business updated successfully.');
        $this->assertRedirectedToAction('BusinessController@index');
    }

    /**
     * @test gets existing business
     */
    public function tests_getting_detail_existing_business()
    {
        $business = array('name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);
        $createdBusiness = BusinessRepository::create($business);
        $this->visit('businesses/'.$createdBusiness['id']);
        $this->see('FTA');
        $this->assertResponseOk();
    }

    /**
     * @test gets not existing business
     */
    public function tests_getting_detail_not_existing_business()
    {
        $business = array('id' => 999999999,
                          'name' => 'FTA',
                          'description' => 'Fight Training Academy',
                          'lat' => -69.3453,
                          'long' => 80.99384);

        $this->get('businesses/'.$business['id']);
        $this->assertSessionHas('flash_notification.message','Business not found');
        $this->assertRedirectedToAction('BusinessController@index');
    }

    /**
     * @test gets list of businesses
     */
    public function tests_getting_list_business()
    {
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

        $this->visit('/home')
             ->see('FTA1')
             ->see(-69.3453)
             ->see(80.99384)
             ->see('FTA2')
             ->see(-69.3453)
             ->see(80.493);
    }
}

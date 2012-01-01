<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class for testing AppUI functionality
 *
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to Clear BSD License. Please see the
 *   LICENSE file in root of site for further details
 *
 * @author      D. Keith Casey, Jr.<caseydk@users.sourceforge.net>
 * @category    w2p_Core_CAppUI
 * @package     web2project
 * @subpackage  unit_tests
 * @copyright   2007-2012 The web2Project Development Team <w2p-developers@web2project.net>
 * @license     Clear BSD
 * @link        http://www.web2project.net
 */

// NOTE: This path is relative to Phing's build.xml, not this test.
include_once 'CommonSetup.php';

class w2p_Core_CAppUI_Test extends CommonSetup
{

    /**
     * Tests the attributes of a new AppUI object
     */
    public function testNewAppUIAttributes()
    {
        global $w2Pconfig;

        $AppUI = new w2p_Core_CAppUI();

        $this->assertInstanceOf('w2p_Core_CAppUI',          $AppUI);
        $this->assertObjectHasAttribute('state',            $AppUI);
        $this->assertObjectHasAttribute('user_id',          $AppUI);
        $this->assertObjectHasAttribute('user_first_name',  $AppUI);
        $this->assertObjectHasAttribute('user_last_name',   $AppUI);
        $this->assertObjectHasAttribute('user_company',     $AppUI);
        $this->assertObjectHasAttribute('user_department',  $AppUI);
        $this->assertObjectHasAttribute('user_email',       $AppUI);
        $this->assertObjectHasAttribute('user_type',        $AppUI);
        $this->assertObjectHasAttribute('user_prefs',       $AppUI);
        $this->assertObjectHasAttribute('day_selected',     $AppUI);
        $this->assertObjectHasAttribute('user_locale',      $AppUI);
        $this->assertObjectHasAttribute('user_lang',        $AppUI);
        $this->assertObjectHasAttribute('base_locale',      $AppUI);
        $this->assertObjectHasAttribute('msg',              $AppUI);
        $this->assertObjectHasAttribute('msgNo',            $AppUI);
        $this->assertObjectHasAttribute('defaultRedirect',  $AppUI);
        $this->assertObjectHasAttribute('cfg',              $AppUI);
        $this->assertObjectHasAttribute('version_major',    $AppUI);
        $this->assertObjectHasAttribute('version_minor',    $AppUI);
        $this->assertObjectHasAttribute('version_patch',    $AppUI);
        $this->assertObjectHasAttribute('version_string',   $AppUI);
        $this->assertObjectHasAttribute('last_insert_id',   $AppUI);
        $this->assertObjectHasAttribute('user_style',       $AppUI);
        $this->assertObjectHasAttribute('user_is_admin',    $AppUI);
        $this->assertObjectHasAttribute('long_date_format', $AppUI);
        $this->assertObjectHasAttribute('objStore',         $AppUI);
        $this->assertObjectHasAttribute('project_id',       $AppUI);
    }

    /**
     * Tests the value of the attributes of a new AppUI object
     */
    public function testNewAppUIAttributeValues()
    {
        global $w2Pconfig;

        $AppUI = new w2p_Core_CAppUI();

        $user_lang = array (
            0 => 'en.ISO8859-15',
            1 => 'enu',
            2 => 'en',
            3 => 'en',
        );

        $cfg = array(
            'locale_warn' => '',
        );

        $this->assertEquals(array(),    $AppUI->state);
        $this->assertEquals(-1,         $AppUI->user_id);
        $this->assertEquals('',         $AppUI->user_first_name);
        $this->assertEquals('',         $AppUI->user_last_name);
        $this->assertEquals(0,          $AppUI->user_company);
        $this->assertEquals(0,          $AppUI->user_department);
        $this->assertEquals('',         $AppUI->user_email);
        $this->assertEquals(0,          $AppUI->user_type);
        $this->assertEquals(array(),    $AppUI->user_prefs);
        $this->assertEquals('',         $AppUI->day_selected);
        $this->assertEquals('en',       $AppUI->user_locale);
        $this->assertEquals($user_lang, $AppUI->user_lang);
        $this->assertEquals('en',       $AppUI->base_locale);
        $this->assertEquals('',         $AppUI->msg);
        $this->assertEquals('',         $AppUI->msgNo);
        $this->assertEquals('',         $AppUI->defaultRedirect);
        $this->assertEquals($cfg,       $AppUI->cfg);
        $this->assertEquals('',         $AppUI->version_major);
        $this->assertEquals('',         $AppUI->version_minor);
        $this->assertEquals('',         $AppUI->version_patch);
        $this->assertEquals('',         $AppUI->version_string);
        $this->assertEquals('',         $AppUI->last_insert_id);
        $this->assertEquals('',         $AppUI->user_style);
        $this->assertEquals(0,          $AppUI->user_is_admin);
        $this->assertEquals('',         $AppUI->long_date_format);
        $this->assertEquals('',         $this->readAttribute($AppUI, 'objStore'));
        $this->assertEquals(0,          $AppUI->project_id);
    }


    /**
     * Test the translation function
     */
	public function test__()
	{
		global $AppUI, $w2Pconfig;

		$w2Pconfig['locale_warn'] = false;
		$this->assertEquals('Company',        $AppUI->__('Company'));
		$this->assertEquals('NoGonnaBeThere', $AppUI->__('NoGonnaBeThere'));

		/* Turn on 'untranslatable' warning */
		$w2Pconfig['locale_warn'] = true;
		$this->assertEquals('Projects^', $AppUI->__('Projects'));
		$this->assertEquals('Add File^', $AppUI->__('Add File'));

		/* Change to another language and reload tranlations */
		$AppUI->user_locale = 'es';
		require W2P_BASE_DIR . '/locales/core.php';
		$this->assertEquals('Proyectos',      $AppUI->__('Projects'));
		$this->assertEquals('Ciudad',         $AppUI->__('City'));
		$this->assertEquals('StillNotThere^', $AppUI->__('StillNotThere'));

		/* Change back to English and reload tranlations */
		$AppUI->user_locale = 'en';
		require W2P_BASE_DIR . '/locales/core.php';
		$this->assertEquals('Projects',        $AppUI->__('Projects'));
		$this->assertEquals('NoGonnaBeThere^', $AppUI->__('NoGonnaBeThere'));
	}

    /**
     * Tests getting a preference
     */
	public function testGetPref()
	{
		global $AppUI;

		$this->assertEquals('en', $AppUI->getPref('LOCALE'));
		$this->assertEquals('',   $AppUI->getPref('NotGonnaBeThere'));
	}

    /**
     * Tests setting a preference
     */
	public function testSetPref()
	{
		global $AppUI;

		$this->assertEquals('en',     $AppUI->getPref('LOCALE'));
		$AppUI->setPref('AddingThis', 'Monkey');
		$this->assertEquals('Monkey', $AppUI->getPref('AddingThis'));
	}

    /**
     * Test setting the global state
     */
    public function testSetState()
    {
        global $AppUI;

        $AppUI->setState('testSetState',    'someValue');
        $this->assertEquals('someValue',    $AppUI->getState('testSetState'));
        $AppUI->setState('testSetState',    'anotherValue');
        $this->assertEquals('anotherValue', $AppUI->getState('testSetState'));
    }

    /**
     * Tests processing the tab state
     */
    public function testProcessTabState()
    {
        global $AppUI;
        $myArray = array('existingKey' => 13, 'existingKey2' => 42);

        $AppUI->processIntState('testProcessState', null,     'existingKey', 9);
        $this->assertEquals(9, $AppUI->getState('testProcessState'));

        $AppUI->processIntState('testProcessState', $myArray, 'existingKey', 9);
        $this->assertEquals(13, $AppUI->getState('testProcessState'));

        $AppUI->processIntState('testProcessNull', $myArray,  'missingKey',  14);
        $this->assertEquals(14, $AppUI->getState('testProcessNull'));

        $AppUI->processIntState('testProcessState', $myArray, 'missingKey',  79);
        $this->assertEquals(13, $AppUI->getState('testProcessState'));
    }

    /**
     * Tests saving the place(url)
     */
	public function testSavePlace()
	{
		global $AppUI;

		$_SERVER['QUERY_STRING'] = 'testUrl';
		$AppUI->savePlace();
		$this->assertEquals('testUrl', $AppUI->getPlace());

		$AppUI->savePlace('?m=projects&amp;a=view&amp;project_id=1');
		$this->assertEquals('?m=projects&amp;a=view&amp;project_id=1', $AppUI->getPlace());
	}

    /**
     * Tests reseting the place(url)
     */
	public function testResetPlace()
	{
		global $AppUI;

		$_SERVER['QUERY_STRING'] = 'testUrl';
		$AppUI->savePlace();
		$this->assertEquals('testUrl', $AppUI->getPlace());
		$AppUI->resetPlace();
		$this->assertEquals('', $AppUI->getPlace());
	}

    /**
     * Tests restoring an object from the global scope
     */
	public function testHoldRestoreObject()
	{
	  global $AppUI;

	  $this->assertNull($AppUI->restoreObject());
	  $myArray = array('one' => 'something', 2 => 'another');
	  $AppUI->holdObject($myArray);

	  $result = $AppUI->restoreObject();
	  $this->AssertEquals(2, count($result));
	  $this->assertArrayHasKey('one', $result);
	  $this->assertArrayHasKey(2, $result);
	  $this->assertNull($AppUI->restoreObject());
	}

    /**
     * Tests setting a message
     */
	public function testSetMsg()
	{
	  global $AppUI, $w2Pconfig;

      $w2Pconfig['locale_warn'] = false;

	  $msg = 'This is a test';
	  $AppUI->setMsg($msg, 0, false);
	  $this->AssertEquals($msg, $AppUI->msg);
	  $AppUI->setMsg($msg, 0, true);
	  $this->AssertEquals($msg.' '.$msg, $AppUI->msg);
	  $AppUI->setMsg($msg, 0, false);
	  $this->AssertEquals($msg, $AppUI->msg);

	  $myArray = array('one' => 'First Message', 'two' => 'Second Message');
      $AppUI->setMsg($myArray, 0, false);
	  $this->AssertEquals('First Message<br />Second Message', $AppUI->msg);

	  $AppUI->setMsg($msg, 0, false);
	  $this->AssertEquals($msg, $AppUI->msg);
    }

    /**
     * Tests getting a system class
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testGetSystemClassValid()
    {
        global $AppUI;

        $this->assertEquals(W2P_BASE_DIR . '/classes/cdate.class.php', $AppUI->getSystemClass('cdate'));
    }

    /**
     * Tests getting a system class when no class name is passed
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testGetSystemClassNoName()
    {
        global $AppUI;

        $this->assertNull($AppUI->getSystemClass());
    }

    /**
     * Test getting a library class
     */
    public function testGetLibraryClassValid()
    {
        global $AppUI;

        $this->assertEquals(W2P_BASE_DIR . '/lib/PEAR/Date.php', $AppUI->getLibraryClass('PEAR/Date'));
    }

    /**
     * Tests getting a library class when no library name is passed
     */
    public function testGetLibraryClassNoName()
    {
        global $AppUI;

        $this->assertNull($AppUI->getLibraryClass());
    }

    /**
     * Tests getting a module class
     */
    public function testGetModuleClassValid()
    {
        global $AppUI;

        $this->assertEquals(W2P_BASE_DIR . '/modules/tasks/tasks.class.php', $AppUI->getModuleClass('tasks'));
    }

    /**
     * Tests getting a module class when no name is passed
     */
    public function testGetModuleClassNoName()
    {
        global $AppUI;

        $this->assertNull($AppUI->getModuleClass());
    }

    /**
     * Tests getting an ajax module file for a module
     */
    public function testGetModuleAjaxValid()
    {
        global $AppUI;

        $this->assertEquals(W2P_BASE_DIR . '/modules/tasks/tasks.ajax.php', $AppUI->getModuleAjax('tasks'));
    }

    /**
     * Tests getting an ajax class for a module when no name is passed
     */
    public function testGetModuleAjaxNoName()
    {
        global $AppUI;

        $this->assertNull($AppUI->getModuleAjax());
    }

    /**
     * Tests that the proper version number is reported
     */
    public function testGetVersion()
    {
        global $AppUI;

        include W2P_BASE_DIR . '/includes/version.php';

        $version = $w2p_version_major . '.' . $w2p_version_minor;
        if (isset($w2p_version_patch)) {
            $version .= '.' . $w2p_version_patch;
        }
        if (isset($w2p_version_prepatch)) {
            $version .= '-' . $w2p_version_prepatch;
        }

        $this->assertEquals($version, $AppUI->getVersion());
    }

    /**
     * Tests getting the time, taking into account the timezone
     */
    public function testGetTZAwareTime()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('now', $datetimezone);
        $df           = $AppUI->getPref('FULLDATEFORMAT');

        $this->assertEquals($datetime->format($df), $AppUI->getTZAwareTime());
    }

    /**
     * Tests converting to system timezone(GMT) with no parameters
     */
    public function testConvertToSystemTZNoParams()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('now', $datetimezone);
        $datetime->setTimezone(new DateTimeZone('Europe/London'));

        $this->assertEquals($datetime->format('Y-m-d H:i:s'), $AppUI->convertToSystemTZ());
    }

    /**
     * Tests converting to system timezone(GMT) with a date passed
     */
    public function testConvertToSystemTZWithDateTime()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('2011-01-01 10:00:00', $datetimezone);
        $datetime->setTimezone(new DateTimeZone('Europe/London'));

        $this->assertEquals($datetime->format('Y-m-d H:i:s'), $AppUI->convertToSystemTZ('2011-01-01 10:00:00'));
    }

    /**
     * Tests converting to system timezone(GMT) with a format passed
     */
    public function testConvertToSystemTZWithFormat()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('now', $datetimezone);
        $datetime->setTimeZone(new DateTimeZone('Europe/London'));

        $this->assertEquals($datetime->format('d/m/Y h:i:s a'), $AppUI->convertToSystemTZ('', 'd/m/Y h:i:s a'));
    }

    /**
     * Tests converting to system timezone(GMT) with a date and format passed
     */
    public function testConvertToSystemTZWithDateTimeAndFormat()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('2011-01-1 10:00:00', $datetimezone);
        $datetime->setTimezone(new DateTimeZone('Europe/London'));

        $this->assertEquals($datetime->format('d/m/Y h:i:s a'), $AppUI->convertToSystemTZ('2011-01-01 10:00:00', 'd/m/Y h:i:s a'));
    }

    /**
     * Tests formatting timezone aware with no params
     */
    public function testFormatTZAwareTimeNoParams()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('now', $datetimezone);

        $this->assertEquals($datetime->format($AppUI->getPref('FULLDATEFORMAT')), $AppUI->formatTZAwareTime());
    }

    /**
     * Tests formatting timezone aware with a date
     */
    public function testFormatTZAwareTimeWithDateTime()
    {
        global $AppUI;

        $timezone     = new DateTimezone($AppUI->getPref('TIMEZONE'));
        $datetimezone = new DateTimeZone('Europe/London');
        $datetime     = new DateTime('2011-01-01 10:00:00', $datetimezone);
        $datetime->setTimeZone($timezone);

        $this->assertEquals($datetime->format($AppUI->getPref('FULLDATEFORMAT')), $AppUI->formatTZAwareTime('2011-01-01 10:00:00'));
    }

    /**
     * Tests formatting timezone aware with a format
     */
    public function testFormatTZAwareTimeWithFormat()
    {
        global $AppUI;

        $timezone     = $AppUI->getPref('TIMEZONE');
        $datetimezone = new DateTimeZone($timezone);
        $datetime     = new DateTime('now', $datetimezone);

        $this->assertEquals($datetime->format('d/m/Y h:i:s a'), $AppUI->formatTZAwareTime('', '%d/%m/%Y %I:%M:%S %p'));
    }

    /**
     * Tests formatting timezone aware with a date and format
     */
    public function testFormatTZAwareTimeWithDateTimeAndFormat()
    {
        global $AppUI;

        $timezone     = new DateTimeZone($AppUI->getPref('TIMEZONE'));
        $datetimezone = new DateTimeZone('Europe/London');
        $datetime     = new DateTime('2011-01-1 10:00:00', $datetimezone);
        $datetime->setTimeZone($timezone);

        $this->assertEquals($datetime->format('d/m/Y h:i:s a'), $AppUI->formatTZAwareTime('2011-01-01 10:00:00', '%d/%m/%Y %I:%M:%S %p'));
    }

    /**
     * Tests checking a users style selection when it is valid
     */
    public function testCheckStyleValidStyle()
    {
        global $AppUI;

        $AppUI->setPref('UISTYLE', 'wps-redmond');
        $AppUI->checkStyle();

        $this->assertEquals('wps-redmond', $AppUI->getPref('UISTYLE'));
    }

    /**
     * Tests checking a users style selection when it is invalid
     */
    public function testCheckStyleInvalidStyle()
    {
        global $AppUI;

        $AppUI->setPref('UISTYLE', 'trevors-style');
        $AppUI->checkStyle();

        $this->assertEquals('web2project', $AppUI->getPref('UISTYLE'));
    }

    /**
     * Test reding directories from an invalid path
     *
     */
    public function testReadDirsInvalidPath()
    {
        global $AppUI;

        $dirs = $AppUI->readDirs('blah');

		$this->assertEquals(0,				count($dirs));
    }


    /**
     * @todo Implement testGetSystemClass().
     */
    public function testGetSystemClass() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetLibraryClass().
     */
    public function testGetLibraryClass() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetModuleClass().
     */
    public function testGetModuleClass() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetModuleAjax().
     */
    public function testGetModuleAjax() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testConvertToSystemTZ().
     */
    public function testConvertToSystemTZ() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testFormatTZAwareTime().
     */
    public function testFormatTZAwareTime() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCheckStyle().
     */
    public function testCheckStyle() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testReadDirs().
     */
    public function testReadDirs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testReadFiles().
     */
    public function testReadFiles() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCheckFileName().
     */
    public function testCheckFileName() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testMakeFileNameSafe().
     */
    public function testMakeFileNameSafe() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetUserLocale().
     */
    public function testSetUserLocale() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testFindLanguage().
     */
    public function testFindLanguage() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLoadLanguages().
     */
    public function testLoadLanguages() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement test_().
     */
    public function test_() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetWarning().
     */
    public function testSetWarning() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetPlace().
     */
    public function testGetPlace() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHoldObject().
     */
    public function testHoldObject() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRestoreObject().
     */
    public function testRestoreObject() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRedirect().
     */
    public function testRedirect() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetMsg().
     */
    public function testGetMsg() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetState().
     */
    public function testGetState() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testProcessIntState().
     */
    public function testProcessIntState() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCheckPrefState().
     */
    public function testCheckPrefState() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLogin().
     */
    public function testLogin() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRegisterLogin().
     */
    public function testRegisterLogin() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRegisterLogout().
     */
    public function testRegisterLogout() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testUpdateLastAction().
     */
    public function testUpdateLastAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLogout().
     */
    public function testLogout() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testDoLogin().
     */
    public function testDoLogin() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLoadPrefs().
     */
    public function testLoadPrefs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetInstalledModules().
     */
    public function testGetInstalledModules() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetActiveModules().
     */
    public function testGetActiveModules() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetMenuModules().
     */
    public function testGetMenuModules() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetLoadableModuleList().
     */
    public function testGetLoadableModuleList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetPermissionableModuleList().
     */
    public function testGetPermissionableModuleList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testIsActiveModule().
     */
    public function testIsActiveModule() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testAcl().
     */
    public function testAcl() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLoadHeaderJS().
     */
    public function testLoadHeaderJS() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetModuleJS().
     */
    public function testGetModuleJS() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testAddFooterJavascriptFile().
     */
    public function testAddFooterJavascriptFile() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLoadFooterJS().
     */
    public function testLoadFooterJS() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLoadCalendarJS().
     */
    public function testLoadCalendarJS() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
}

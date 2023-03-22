1. Installing the package using Composer
Open a Command Prompt window and change the working directory to your Laravel app’s main directory.
Enter the command composer require miniorange/saml-laravel-free.

Laravel Single Sign On SSO enter commond
Note: If you are using Laravel 5.4 or below, you will need to add the following value to the 'providers' array in your app.php file which can be found in the project\config folder :provider\ssoServiceProvider::class

You can check your current Laravel version by using the command php artisan --version.

Laravel Single Sign On SSO add following value
After successful installation of package, go to your Laravel app in the browser and enter https://<your-host>/mo_admin in the address bar.
The package will start setting up your database for you and then redirect you to the admin registration page.
Login with credentials you registered with.
Laravel Single Sign On SSO plugin settings

2. Configuring the Laravel SSO SP plugin
Go to the plugin and Select Plugin Settings tab from the navigation panel on the left.
If you go to the plugin settings tab you will find the SP Entity ID and ACS URL, which will be required when configuring your Identity Provider. This information can be configured manually or downloaded using the Download button.
Laravel Single Sign On SSO Service Provider Settings
Now, under the Identity Provider Settings section you can upload your Identity Provider details to configure the plugin using the below ways.
1. Upload Identity Provider metadata file/XML :

You can upload your Identity Provider metadata file using Upload Metadata option.
Laravel Single Sign On SSO Identity Provider Settings
2. Add Identity Provider metadata details manually :

You can enter your Identiity Provider metadata details manually.(Refer the image below)
Laravel Single Sign On SSO Identity Provider Settings
Click on the Save button to save your settings.
Laravel Single Sign On SSO Identity Provider Settings
3. Test Configuration
Once you configured all the details of your identity provider,you can test if the plugin is configured properly or not by clicking on the Test Configuration button.
Laravel Single Sign On SSO Test Configuration
You should see a Test Successful screen as shown below along with the user's attribute values.
Laravel Single Sign On SSO Test Result
4. SSO Options
You can configure the Relay State URL in the Service Provider Settings if you want to redirect users to a custom URL after the SSO.
Your users can initiate the Single Sign On flow by clicking on the Single Sign On button generated on your login page. If you do not have this page yet, run php artisan make:auth & php artisan migrate to generate the authentication module.

Laravel Single Sign On SSO Single Sign On button
5. Support / Demo
Support and trial tabs are available for customers to reach out to for demos and support.
Laravel Single Sign On SSO Single Sign On button Laravel Single Sign On SSO Single Sign On button
If you don't find what you are looking for, please contact us at laravelsupport@xecurify.com or call us at +1 978 658 9387 to find an answer to your question about MiniOrange Laravel SAML.

miniorange logo
+1 978 658 9387 (US)
+91 97178 45846 (India)

info@xecurify.com

STAY CONNECTED
   
Product
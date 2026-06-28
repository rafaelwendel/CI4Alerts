# CI4Alerts

**CI4Alerts** is a helper library for the **CodeIgniter 4** framework designed to simplify the creation, management, and display of message alerts (such as success, error, and warning messages) using the most popular CSS frameworks: **Bulma**, **Bootstrap**, **Materialize**, and **Tailwind CSS**.

---

## Installation

The package can be easily installed via **Composer**. Run the following command in your terminal at the root of your CodeIgniter 4 project:

```bash
composer require rafaelwendel/ci4alerts
```

---

## Configuration

### Setup Command (Spark)

After installing the library, you should publish the package's default configuration template file to your application's Config directory (`app/Config`). To do this, run the Spark command below in your terminal:

```bash
php spark alerts:setup
```

This command will copy the configuration template file to `app/Config/Alerts.php`.

---

### Configuration Options

When you open `app/Config/Alerts.php`, you will find the following configuration options:

*   **`$active`**: Defines the default styling library that will be used by the service. The supported options are:
    *   `'bulma'` (Default)
    *   `'bootstrap'`
    *   `'materialize'`
    *   `'tailwind'`
*   **`$config`**: Contains framework-specific styling and behavior sub-arrays for each supported CSS framework. The options inside each framework sub-array are:
    *   `classSucess`: CSS class applied to success alerts.
    *   `classError`: CSS class applied to error/danger alerts.
    *   `classWarning`: CSS class applied to attention/warning alerts.
    *   `sessionMsg`: Session key name (flashdata) used to store the message text.
    *   `sessionMsgType`: Session key name (flashdata) used to store the message type.
    *   `template`: HTML template where the CSS class and message will be injected. Supports PHP formatting placeholders (`%s`) or replacement tags (`{class}` and `{message}`).

### Adding Custom Configurations

If you do not want to use any of the built-in libraries, you can easily define your own custom configurations by adding new keys to the `$config` array. To use a custom configuration, simply set the `$active` property to your custom key:

```php
public $active = 'my_custom_theme';

public $config = [
    // ...
    'my_custom_theme' => [
        'classSucess'    => 'my-custom-success-class',
        'classError'     => 'my-custom-danger-class',
        'classWarning'   => 'my-custom-warning-class',
        'sessionMsg'     => 'msg',
        'sessionMsgType' => 'msg_type',
        'template'       => '<div class="%s">%s</div>',
    ],
];
```

You can then load your custom theme automatically:
```php
$alerts = service('alerts'); // Uses 'my_custom_theme'
```
Or load it explicitly by passing its key as an argument:
```php
$alerts = service('alerts', 'my_custom_theme');
```

---

## Usage Examples

### 1. Obtaining the Service Instance

The recommended way to instantiate the library is using CodeIgniter 4's `service()` helper:

```php
// Instantiates using the default framework defined in the active property of app/Config/Alerts.php
$alerts = service('alerts');

// Instantiates forcing a specific framework override
$alertsBootstrap = service('alerts', 'bootstrap');
```

---

### 2. Setting Alert Messages (Controller)

You can store alert messages in session flashdata to display them after a redirect (e.g., after saving a form):

```php
namespace App\Controllers;

class Products extends BaseController
{
    public function save()
    {
        // ... saving logic ...

        // Set a success alert
        service('alerts')->set('Product registered successfully!', 'success');

        // Or set an error alert
        service('alerts')->set('Could not save the product.', 'error');

        return redirect()->to('/products');
    }
}
```

---

### 3. Displaying Alert Messages (Views)

#### Automatic Session (Flashdata) Display
To display the alert set in the controller, simply call the `display()` method in your view:

```php
<?= service('alerts')->display() ?>
```

#### Direct Display (Without Session / Static Rendering)
If you prefer to render a message directly in the view, pass the parameters to the `display()` method:

```php
<?= service('alerts')->display('This is a direct message!', 'warning') ?>
```

#### Shortcut Helper Methods
You can also use type-specific shortcut methods directly in the view:

```php
// Success Alert
<?= service('alerts')->success('Operation completed successfully!') ?>

// Error Alert
<?= service('alerts')->error('A connection error occurred.') ?>

// Warning Alert
<?= service('alerts')->warning('Your plan will expire in 3 days.') ?>
```

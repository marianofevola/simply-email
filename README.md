# Usage
Create a simply-mail.yml file in the root of your project where you specify 
your default values for the emails. 

Example:

```yaml
from: "Johnny <jhonny@dep.com>"
isHtml: true

```

These values can be overwritten at any time using Email's methods like this:

```php
use MFevola\SimplyEmail\Email;

$email = new Email();

$email
  ->setMessage("Testing email message")
  ->setSubject("This is a test")
  ->setFrom("my-email@address.com")
  ->setTo("my-friend@address.com")
  ->send();

```

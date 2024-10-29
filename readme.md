# HTML to PDF Printer PHP Client

**HTML to PDF Printer PHP Client** is a PHP SDK designed for interacting with the [HTML to PDF Printer service](https://github.com/Multidialogo/html-to-pdf-printer). This library simplifies the process of converting HTML content into PDF documents through a RESTful API, allowing developers to integrate PDF generation seamlessly into their applications.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

- Easy integration with the HTML to PDF Printer service via a RESTful API.
- Utilizes Guzzle HTTP client for efficient request handling.
- Supports dynamic HTML content for flexible PDF generation.
- Comprehensive error handling for robustness.

## Installation

You can install the library using Composer. Run the following command in your project directory:

```bash
composer require multidialogo/html-to-pdf-printer-php-client
```

Ensure you have [Composer](https://getcomposer.org/) installed before executing this command.

## Usage

### Basic Setup

1. **Include the Autoloader:**

   Start by including the Composer autoloader in your PHP script:

   ```php
   require 'vendor/autoload.php';
   ```

2. **Create an Instance of the Client:**

   Instantiate the client by providing the base URI of the HTML to PDF Printer service:

   ```php
   use MultiDialogo\HtmlToPdfPrinterPhpClient\Client;

   $client = new Client('https://api.example.com'); // Replace with the actual API base URI
   ```

### Converting HTML to PDF

You can convert HTML to a PDF stream by using the `getHtmlAsPdfStream` method:

```php
try {
    $callerService = 'your-service-name'; // Name of the calling service
    $htmlBody = '<h1>Hello, World!</h1>'; // Your HTML content

    $pdfStream = $client->getHtmlAsPdfStream($callerService, $htmlBody);

    // Output the PDF stream to the browser
    header('Content-Type: application/pdf');
    fpassthru($pdfStream);
    fclose($pdfStream);
} catch (RuntimeException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Examples

For additional examples and use cases, refer to the [examples](examples/) directory in this repository.

### Error Handling

This SDK includes error handling for scenarios such as missing files or HTTP request failures. Wrap your method calls in try-catch blocks to manage exceptions effectively.

## API Reference

### Client Class

- **`__construct(string $baseUri)`**: Initializes the client with the base URI of the HTML to PDF Printer service.
- **`setClient(GuzzleHttpClient $guzzleClient)`**: Optionally sets a custom Guzzle HTTP client instance.
- **`getHtmlAsPdfStream(string $callerService, string $htmlBody)`**: Converts HTML content to a PDF stream.
    - **Parameters:**
        - `string $callerService`: The name of the calling service for identification.
        - `string $htmlBody`: The HTML content to convert.
    - **Returns:** A stream resource for the generated PDF.
    - **Throws:** `RuntimeException` if the generated PDF file is missing.

## Contributing

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a pull request.

### Launch tests (local provisioning)

```bash
<<<<<<< HEAD
docker compose run --rm test
```

Please ensure your code follows coding standards and passes any existing tests.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For any inquiries or issues, feel free to reach out:

- **Author**: [Your Name](https://github.com/YourProfile)
- **Email**: [your.email@example.com](mailto:your.email@example.com)

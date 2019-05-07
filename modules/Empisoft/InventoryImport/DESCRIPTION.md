We need to have functionality that will import stock data from sftp.
Configurations must be placed in admin backend and be accessible only to admin users with correct permissions.

Stock data might be in csv, xml, json format because we import them from different manufacturers. Please choose one of the above formats to implement, just having in mind that multiple formats should be easily supported.

CSV columns are always like there is no header with columns names:
Stock id (manufacturer internal)
Product sku
Quantity
Warehouse id (where product is placed)

XML format is:

```
<?xml version="1.0" encoding="UTF-8"?>
    <items>  
        <item>
            <id>product sku</id>
            <gtin>5060472351036</gtin>
            <condition>New</condition>
            <color>Black</color>
            <mpn>5060472351036</mpn>
            <brand>Some Brand</brand>
            <availability>in stock</availability>
            <price>599 GBP</price>
            <quantity>5.0000</quantity>
        </item>
    </items>
```

	
JSON always has the same structure as xml file format.

Currently we are not using any third party multistock inventory module, but we might want to use it in future. Optional - you can describe multiple inventory approach instead of implementing it. Keep in mind latest changes in Magento core.


We need multiple entry points to application. Cron,Console and admin ui based. Please choose one of the entry points, while having in mind multiple entry points support.

Cron settings (time when is run) must be editable in admin backend panel next to credentials configuration.

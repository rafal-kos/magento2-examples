README  
------------

Module is based on Magento 2.3 version with MSI. Handling additional inventory sources is quite easy. In this line   
```$sourceItem->setSourceCode('default');``` we should just add data from imported source  

------------  

I'm using   
* \Magento\InventoryApi\Api\SourceItemsSaveInterface  
* \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory  
  
as \Magento\CatalogInventory\Api\StockRegistryInterface is deprecated from 2.3 version  
  
-------  

I have created adapter based on \Magento\ImportExport\Model\Import\AbstractSource. I had to overwrite Csv source adapter as   
the original one was ignoring first line where should be column names.  
  
----------------  

XML provided in specs was not valid as root node was missing. Correct content should be something like this :  
  
```$xslt  
<?xml version="1.0" encoding="UTF-8"?>  
<items>  
   <item>  
        <id>SKU-01</id>  
        <gtin>5060472351036</gtin>  
        <condition>New</condition>  
        <color>Black</color>  
        <mpn>5060472351036</mpn>  
        <brand>Some Brand</brand>  
        <availability>in stock</availability>  
        <price>599 GBP</price>  
        <quantity>25</quantity>  
   </item>  
   <item>  
        <id>SKU-02</id>  
        <gtin>5060472351036</gtin>  
        <condition>New</condition>  
        <color>Black</color>  
        <mpn>5060472351036</mpn>  
        <brand>Some Brand</brand>  
        <availability>in stock</availability>  
        <price>599 GBP</price>  
        <quantity>29</quantity>  
   </item>  
</items>  
```  
------  
How to add handle new type of import file : in custom module in ```di.xml``` you have to add those lines  
```  
<type name="Empisoft\InventoryImport\Model\Import\Source\AdapterList">  
        <arguments>  
            <argument name="adapters" xsi:type="array">  
                <item name="empisoft_json_adapter" xsi:type="object">Vendor\ImportJson\Model\Import\Source\JsonFactory</item>             
            </argument>  
        </arguments>  
    </type>  
```  
Example in module ```Empisoft_InventoryImportJson```.

----------
```Empisoft\InventoryImport\Api\StockImportInterface``` can be replaced when for example we would need to handle huge catalog and instead of using ```SourceItemInterface```
we could process those imports with queue
 
----------
Remarks :  
  
* Adding new import data source should be quite easy. For JSON we should create new source model.  
* I am using XMLReader as it handles better and faster with bigger xml files
* cron job name : ```empisoft_import_stock```  
* command name : ```empisoft:import-stock```
-------
TODO : 
* better error handling
* log errors
* handle import for multiple stores
* fix ACL as now giving user rights to edit sftp connection gives access also to othere cataloginventory options 
* tests

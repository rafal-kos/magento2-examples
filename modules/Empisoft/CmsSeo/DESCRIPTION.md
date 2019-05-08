A multi-site setup with some CMS pages that are shared across the different websites. 

The problem that we are having is that this is causing duplicate content issues and addecting the SEO rankings. 

As well I have to add a new config in the admin area which will be filled with store language that is different than magento language for example "en-us" and "en-gb" this because meta tag must have specific values for each country. 

The meta tag will be structured as follows: 
```
<link rel="alternate" hreflang="en-us" href="https://example.url/cms-page-url" />
```
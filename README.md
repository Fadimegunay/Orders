## Kurulum
* <code>cd</code>  komutunu kullanarak  dosya dizinine ilerleyin
* <code>.env.example</code> dosyasını <code>.env</code> dosyasına kopyalın ve database bilgilerinizi doldurun
* Sırasıyla  <code>composer install </code> ve <code>composer update</code> komutlarını çalıştırın
* <code>php artisan key:generate</code> komutunu çalıştırın
* Sırasıyla <code>php artisan migrate</code> ve <code>php artisan db:seed</code> komutlarını çalıştırın


## API URL
* <code>{your_site}/api/orders</code> -> Siparişleri Listeleme (GET)
* <code>{your_site}/api/order/create</code> -> Sipariş Oluşturma (POST - customerId(integer), productId(array), quantity(array) form data olarak gönderip istek atabilirsiniz)
* <code>{your_site}/api/order/{orderId}</code> -> Siparişi Silme (DELETE)
* <code>{your_site}/api/order/discount/{orderId}</code> -> Sipariş için indirim hesaplama (GET)

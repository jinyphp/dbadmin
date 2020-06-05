# View
본 코드는 `PHP`언어로 작성된 `composer` 페키지 입니다. 또한 `jinyPHP` 프레임워크와 같이 동작을 합니다.
지니PHP는 MVC 패턴의 웹프레임워크 입니다.


## 설치방법
composer를 통하여 설치를 진행할 수 있습니다.

```php
composer require jiny/view
```


## 소스경로
모든 코드는 깃허브 저장소에 공개되어 있습니다.
https://github.com/jinyphp/view

누구나 코드를 포크하여 수정 및 개선사항을 기여(contrubution)할 수 있습니다.


## 뷰
지니PHP 의 MVC패턴의 view를 처리하는 패키지 입니다. 
뷰는 컨드롤러에 의해서 호출되며, 컨트롤러에서 작업한 결과물을 화면에 처리하여 http response로 반환을 합니다.  

http response는 반환된 뷰의 화면을 브라우저로 전송하고, 브라우저는 전송받은 데이터를 기준으로 화면을 렌더링 하게 됩니다.

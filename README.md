# Cloud Music Webapp

- [X] Login and register form `(1/1/2020 Finished)`
- [X] Completing the signup and login process
- [X] Styling the registration page
- [ ] Now playing bar
- [ ] Navigation menu
- [ ] Music main page
- [ ] Album page
- [ ] The music player
- [ ] Seamless page transitions
- [ ] Artist page
- [ ] Serach music page
- [ ] Playlists
- [ ] Song options
- [ ] Setting page
- [ ] Upload to internet

<br><br>

| Function                                                                          | Finished Date |
| --------------------------------------------------------------------------------- | ------------- |
| <input type="checkbox" disabled checked /> <b>Login and register form</b>         |    1/1/2020   |
| <input type="checkbox" disabled checked /> <b>Signup and login process</b>        |    2/1/2020   |
| <input type="checkbox" disabled checked /> <b>Styling the registration page</b>   |    3/1/2020   |
| <input type="checkbox" disabled /> <b>Now playing bar</b>                         |               |
| <input type="checkbox" disabled /> <b>Navigation menu</b>                         |               |
| <input type="checkbox" disabled /> <b>Music main page</b>                         |               |
| <input type="checkbox" disabled /> <b>Album page</b>                              |               |
| <input type="checkbox" disabled /> <b>The music player</b>                        |               |
| <input type="checkbox" disabled /> <b>Artist page</b>                             |               |
| <input type="checkbox" disabled /> <b>Serach music page</b>                       |               |
| <input type="checkbox" disabled /> <b>Playlists</b>                               |               |
| <input type="checkbox" disabled /> <b>Song options</b>                            |               |
| <input type="checkbox" disabled /> <b>Setting page</b>                            |               |
| <input type="checkbox" disabled /> <b>Upload to internet</b>                      |               |

<br><br>

## Login and register form

`知識點：`

* 在每個input的value屬性加入keepValueLastTime function，以便每一次submit錯誤時，輸入值保留在input field。
* 寫好每一個input的name屬性，以便使用PHP接受正確的值
* 創造函數用來防範各種攻擊，例如SQL注入，XSS等。
* login-handler.php中，我使用FILTER_VALIDATE_EMAIL判斷了輸入值是否位email，如不是則表示用戶是使用username登錄，從而通過不同的函數驗證，這允許了用戶有兩種的登錄方式。

<br><br>

## Signup and login process

`知識點：`

* 使用PHP的構造函數來創建errorArray, 用來接受error message。
* 在Account.php 中，每一次驗證完之後再判斷有無error message，如有就使用array_push將此信息添加入errorArray，並通過getError輸出錯誤信息。
* 爲了更方便的統一修改，我使用PHP中的static 來定義錯誤信息。
* 爲了與database鏈接，將$pdo傳入class Account中的構造函數，以便下方的驗證使用。
* register-handler.php中的$wasSuccessed用來接受boolean值。如成功就將username存入session，並通過header將網頁導向至index.php. 在index.php也通過判斷，如不存在session值，即登入失敗，將自動導向至register頁面。

## Styling the registration page

`知識點：`

* 在register.js中通過click函數實現點擊改變display值，如none及block，從而實現點擊跳轉login page 和 register page。同時，因爲用戶在註冊界面即使輸入錯誤仍會跳轉至login page，因此使用了PHP添加js代碼以此確保用戶點擊後維持原界面。 


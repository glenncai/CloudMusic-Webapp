# Cloud Music Webapp

| Function                                                                          | Finished Date |
| --------------------------------------------------------------------------------- | ------------- |
| <input type="checkbox" disabled checked /> <b>Login and register form</b>         |    1/1/2020   |
| <input type="checkbox" disabled checked /> <b>Signup and login process</b>        |    2/1/2020   |
| <input type="checkbox" disabled checked /> <b>Styling the registration page</b>   |    3/1/2020   |
| <input type="checkbox" disabled checked /> <b>Now playing bar</b>                 |    4/1/2020   |
| <input type="checkbox" disabled checked /> <b>Navigation menu</b>                 |    5/1/2020   |
| <input type="checkbox" disabled checked /> <b>Music main page</b>                 |    6/1/2020   |
| <input type="checkbox" disabled checked /> <b>Album page</b>                      |    7/1/2020   |
| <input type="checkbox" disabled checked /> <b>The music player</b>                |    8/1/2020   |
| <input type="checkbox" disabled checked /> <b>Artist page</b>                     |    9/1/2020   |
| <input type="checkbox" disabled checked /> <b>Serach music page</b>               |    11/1/2020  |
| <input type="checkbox" disabled checked /> <b>Playlists</b>                       |    13/1/2020  |
| <input type="checkbox" disabled checked /> <b>Song options</b>                    |    16/1/2020  |
| <input type="checkbox" disabled /> <b>Setting page</b>                            |    17/12020   |
| <input type="checkbox" disabled /> <b>Upload to internet</b>                      |               |

<br><br>

## Login and register form

`知識點：`

* 在每個input的value屬性加入keepValueLastTime function，以便每一次submit錯誤時，輸入值保留在input field。
* 寫好每一個input的name屬性，以便使用PHP接受正確的值
* 創造函數用來防範各種攻擊，例如SQL注入，XSS等。
* login-handler.php中，我使用FILTER_VALIDATE_EMAIL判斷了輸入值是否爲email，如不是則表示用戶是使用username登錄，從而通過不同的函數驗證，這允許了用戶有兩種的登錄方式。

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

* 在register.js中通過click函數實現點擊改變display值，如none及block，從而實現點擊跳轉login page 和 register page。同時，因爲當用戶處於註冊界面，即使用戶輸入錯誤仍會自動跳轉至login page，因此使用了PHP添加js代碼以此確保用戶點擊後維持原界面。 


CREATE TABLE Songs (
	song_id INTEGER NOT NULL AUTO_INCREMENT,
    title VARCHAR(250),
    duration VARCHAR(8),
    path VARCHAR(500),
    plays INTEGER,
    albumOrder INTEGER,
    lyrics VARCHAR(600),
    artist_id INTEGER,
    album_id INTEGER,
    genre_id INTEGER,
    PRIMARY KEY(song_id),
    INDEX USING BTREE (title),
    
    CONSTRAINT FOREIGN KEY (artist_id) REFERENCES Artists (artist_id) ON DELETE 	     CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (album_id) REFERENCES Albums (album_id) ON DELETE 	         CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (genre_id) REFERENCES Genres (genre_id) ON DELETE 	         CASCADE ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Albums (
	album_id INTEGER NOT NULL AUTO_INCREMENT,
    title VARCHAR(250),
    artist_id INTEGER,
    genre_id INTEGER,
    artworkPath VARCHAR(500),
    PRIMARY KEY (album_id),
    INDEX USING BTREE (title),
    CONSTRAINT FOREIGN KEY (genre_id) REFERENCES Genres (genre_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (artist_id) REFERENCES Genres (artist_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = INNODB;


PHP is a server-side programming language. It gets executed when you request a page. So you cannot execute it after the page has been loaded. If you need to check if something has loaded on the client-side, you'll have to use a client-side programming language like JavaScript.




If you don't want an element to be selected after being pressed and swiped by the mouse, you can use this method in jQuery.

$(document).ready(function() {
    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
        e.preventDefault();
    });
});


But I found that this will cause the problem in moblie platfrom. The button cannot be clicked in mobile.

The best way to solve it by using CSS, the button can be clicked in mobile devices. See the following code:

    -moz-user-select:none;/*Firefox*/
    -webkit-user-select:none;/*webkit*/
    -ms-user-select:none;/*IE10*/
    -khtml-user-select:none;/*Old browser*/
    user-select:none;




BUG: When add the circle progress to the progress line, it causes some bugs
Solution: We can make remove any mouse interaction with the image by addding `pointer-events: none;`

When I declare a variable which is `userLoggedIn` by `let` in script. And try to accept the `$_SESSION['userLoggedIn'];` in header.php, the variable always undefined. It is because that when we use `let`, global variables defined with the `let` keyword do not belong to the window object. When I try to use `var`, it is working. Global variables defined with the `var` keyword belong to the window object.


BUG: Always appear => Uncaught SyntaxError: Identifier 'tempSongIds' has already been declared when declare variable by 'let'. So I try to use 'var' instead of it then fixed it.


When "keyup" event is happen, we should ensure that the input is still focus on the last character of input value. There are three solution:

Work for Coogle Chrome, and Firefox. (already tested)

First, we shoud add `element.focus()` outside the addEventlistener. Then choose any of blow choices adding to `<input> tag`
* onfocus="var val=this.value; this.value=''; this.value= val;"
* onfocus="this.selectionStart = this.selectionEnd = this.value.length;"
* onfocus="var val=this.value; this.value=''; this.value= val;" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"

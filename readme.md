## 说明

```json
1. Endpoint：http://fakerapi.qiji.tech
2. common header
  - version-code：版本号
  - version-name：版本名称
  - device：设备唯一编号
  - channel：渠道号
  - platform：平台类型「android、iOS」
  - Authorization: Bearer {yourtokenhere}「登录用户token传到header里面」
  - Accept: application/vnd.lureapp.v1+json
3. code
  - 200：代表成功返回数据
4. status_code
  - 404：代表没有找到对应的 API 或者 Entity
  - 422：代表没有条件校验不通过
  - 403：用户名或密码不正确
  - 401：未登录
```

## Response数据结构

```json
1. {

}

2. [

]

3. {
    "message": "422 Unprocessable Entity",
    "errors": {
        "category_id": [
            "The category id field is required."
        ]
    },
    "status_code": 422
}

4. {
    "message": "404 Not Found",
    "status_code": 404
}

5. {
    "message": "The version given was unknown or has no registered routes.",
    "status_code": 400
}

6. {
    "message": "用户名或密码不正确",
    "status_code": 403
}

7. {
    "message": "Failed to authenticate because of bad credentials or an invalid authorization header.",
    "status_code": 401
}
```

***

### 注册

* 地址： POST /auth/register
* Demo：http://fakerapi.qiji.tech/auth/register
* 参数：
  	- phone： 手机号码
	- password：密码
* Response

  ```json
  {
    "message": "用户名或密码不正确",
    "status_code": 403
  }

  ```

### 登录

* 地址： POST /auth/login
* Demo：http://fakerapi.qiji.tech/auth/login
* 参数：
  - phone： 手机号码
  - password：密码
* Response

  ```json
  {
    "id": 1,
    "phone": "186xxxx4602",
    "nickname": null,
    "real_name": null,
    "email": null,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cLzEyMy41Ny43OC40NVwvYXV0aFwvbG9naW4iLCJpYXQiOiIxNDQ2MjYxNDAxIiwiZXhwIjoiMTQ0NjI2NTAwMSIsIm5iZiI6IjE0NDYyNjE0MDEiLCJqdGkiOiJkNzYzYWZhNzNmMGM0NWQ1NThmNGFjOWMwMDQ2NzQwYiJ9.Fue9C67TEpSni_uHuFGV3L5sNzuLBVRoelUr2gb4Hbk"
  }
  ```

### 动态列表

#### 通过page分页

* 地址： GET /feeds
* Demo：http://fakerapi.qiji.tech/feeds
* 参数：
    - page：当前页「从1开始」
    - page_size：每页显示条数，默认20条「optional」
* Response

```json
 [
  {
    "id": 200,
    "status": "ENABLE",
    "content": "Rem voluptatibus sunt deleniti non voluptatum accusantium aut. Aut voluptatem porro soluta dolores.",
    "share_times": 2773,
    "browse_times": 6327,
    "comment_times": 592273761,
    "created_at": 1453993084,
    "user": {
      "id": 5,
      "nickname": "Jazmyne Huel",
      "avatar": "http://lorempixel.com/180/180/?97237"
    },
    "images": [
      {
        "id": 153,
        "width": 540,
        "height": 960,
        "url": "http://lorempixel.com/540/960/?35509"
      }
    ]
  }
]
```

#### 通过id分页

* 地址： GET /feeds
* Demo：http://fakerapi.qiji.tech/feeds
* 参数：
    - max-id：loadmore使用
    - since-id：refresh使用
    - page_size：每页显示条数，默认20条「optional」
    
    ```
    max-id和since-id不同时使用
    ```
    
* Response

```json
 [
  {
    "id": 200,
    "status": "ENABLE",
    "content": "Rem voluptatibus sunt deleniti non voluptatum accusantium aut. Aut voluptatem porro soluta dolores.",
    "share_times": 2773,
    "browse_times": 6327,
    "comment_times": 592273761,
    "created_at": 1453993084,
    "user": {
      "id": 5,
      "nickname": "Jazmyne Huel",
      "avatar": "http://lorempixel.com/180/180/?97237"
    },
    "images": [
      {
        "id": 153,
        "width": 540,
        "height": 960,
        "url": "http://lorempixel.com/540/960/?35509"
      }
    ]
  }
]
```


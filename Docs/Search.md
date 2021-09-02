
**Search Sent Messages**
----
  Returns json array of messages matching given search parameters.

* **URL**

  /search/:key/:value

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `key=[string] -- The field to search on`
   `value=[integer,boolean,string,date] -- The value to search by`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    [
      {
        "id": "99999",
        "msg_name": "test",
        "to": [
          "test@test.com"
        ],
        "subject": "A Test",
        "body": "Sent using Postman",
        "cc": [
          ""
        ],
        "bcc": [
          ""
        ],
        "attachements": [
          ""
        ],
        "flag": null,
        "sent_by": null,
        "created_date": "2021-09-01 14:37:50"
      },
    ....]    
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Unknown column 'garbage' in 'where clause'" }`

  OR

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

   OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/search/msg_name/test",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```

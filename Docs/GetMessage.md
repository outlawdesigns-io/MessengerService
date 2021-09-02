**Get Message**
----
  Returns json data about a single message.

* **URL**

  /message/:id

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
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
    }
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Invalid UID" }`

  OR

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

   OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/message/99999",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```

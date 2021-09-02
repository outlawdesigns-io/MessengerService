**Has Message been sent?**
----
  Returns a boolean value indicating whether or not a specific message has been sent base on a message's `msg_name` and `flag` properties.

* **URL**

  `/sent/:msg_name/:flag`

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `msg_name=[string] -- The field to search on`
   `flag=[string] -- The value to search by`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    true
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ "error": "Message name string must be specified" }`

  OR
   * **Code:** 200 <br />
    **Content:** `{ "error": "Message flag must be specified" }`

  OR
  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

  OR
    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/sent/http_404_probe/SOME_IP_ADDRESS",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```

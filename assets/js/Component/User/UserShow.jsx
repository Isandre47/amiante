import React, {Component} from "react";
import {useParams} from "react-router-dom";

function UserShow() {

  let user = useParams();
  console.log(user);

    return (
        <div>
          View User {user.userId}
        </div>
    )
}

export default UserShow

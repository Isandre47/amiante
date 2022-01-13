import React, {Component, useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import axios from "axios";

function UserShow() {

  let user = useParams();
  const [userInfo, setUserInfo] = useState([]);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    getUser();
  }, [])

  function getUser() {
    axios.get('/user/'+user.userId).then((userShow) => {
      console.log('user data', userShow.data)
      setUserInfo(userShow.data);
      setIsLoading(false);
    }).catch(error => {
      console.log('error', error)
      if (error.response) {
        console.log('error response', error.response);
      } else if (error.request) {
        console.log('error request', error.request);
      } else {
        console.log('error message', error.message);
      }
    })
  }
  if (isLoading) return 'loading !! ';
  return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{height: '10vh'}}>
            <div className="col-12 text-center">
              <h1>Salut {userInfo.firstname} {userInfo.lastname} !</h1>
            </div>
          </div>
          <hr/>
          <div className={'row'}>
            <div className={'col-6'}>
              {/*<h3>{userInfo.site.map(item => <span>item.name</span>)}</h3>*/}
            </div>
          </div>
          View User {user.userId}
        </div>
    )
}

export default UserShow

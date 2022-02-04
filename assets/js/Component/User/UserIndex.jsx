import React, {Component, useEffect, useState} from "react";
import axios from "axios";
import {Link, Route, Routes, Outlet} from "react-router-dom";

function UserIndex () {

  const [users, setUsers] = useState([]);

  useEffect(() => {
    getUsers();
  }, [])

  function getUsers() {
    axios.get('/api/user/users_page').then(users => {
      console.log('page user', users.data)
      setUsers(users.data.users)
    })
  }

    return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{height: '4rem'}}>
            <div className={'col-12 text-center'}>
              <h1>Index des utilisateurs !</h1>
            </div>
          </div>
          <hr/>
          <Link to={'/user/add'} className={'nav-link'} >Ajouter un utilisateur</Link>
          <div className={'row m-3'}>
            <table className={'table table-striped table-hover'}>
              <thead>
              <tr>
                <td>email</td>
                <td>Nom prénom</td>
                <td>Chantier actuel</td>
                <td>Gestion</td>
              </tr>
              </thead>
              <tbody>
              {
                users.map(user =>
                    <tr key={user.id}>
                      <td>{user.email}</td>
                      <td>{user.lastname} {user.firstname}</td>
                      <td className={user.site === null ? 'bg-primary': ''}>
                        {user.site === null ? <span>gère des chantiers</span> : user.site.name}<
                      /td>
                      <td>
                        <a href="#">Editer</a>
                        -
                        <Link to={`/api/user/${user.id}`} className={'nav-link'} key={user.id}> Plus d'infos... {user.id}</Link>
                      </td>
                    </tr>
                )
              }
              </tbody>
            </table>
          </div>
        </div>
    )
}

export default UserIndex

import React, {useEffect, useState} from "react";
import axios from "axios";
import {Link} from "react-router-dom";

function UserIndex () {

  const [users, setUsers] = useState([]);

  useEffect(() => {
    getUsers();
  }, [])

  function getUsers() {
    axios.get('/api/user/users_index').then(users => {
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
                        <Link to={`/user/edit/${user.id}`} className={'nav-link'} edit={'true'}>Editer</Link>
                        -
                        <Link to={`/user/show/${user.id}`} className={'nav-link'}> Plus d'infos... {user.id}</Link>
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

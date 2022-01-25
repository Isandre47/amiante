import React from "react";

function UserAdd() {
  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '4rem'}}>
          <div className={'col-12 text-center'}>
            <h1>Ajout d'un utilisateur</h1>
          </div>
        </div>
        <hr/>
        <div>
          <form className={'form-group'}>
            <label htmlFor="">Nom
              <input type="text"/>
            </label>
            <input className={'form-control'} type="submit" value={'Envoyer'}/>
          </form>
        </div>
      </div>
  )
}

export default UserAdd

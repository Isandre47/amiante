import React, {useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import axios from "axios";

function SiteShow() {

  let site = useParams();
  const [siteInfo, setSiteInfo] = useState([]);
  const [siteUsersInfo, setSiteUsersInfo] = useState([]);
  const [siteEquipmentsInfo, setSiteEquipmentsInfo] = useState([]);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    getSite();
  }, [])

  function getSite() {
    axios.get('/api/site/show/'+site.siteId).then((siteShow) => {
      console.log('site data', siteShow.data);
      setSiteInfo(siteShow.data);
      setSiteUsersInfo(siteShow.data.users);
      setSiteEquipmentsInfo(siteShow.data.equipment);
      setIsLoading(false);
    }).catch(error => {
      console.log('error', error);
    })
  }

  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'}>
          <div className={'col-12 text-center'}>
            <h1> Chantier {siteInfo.name}</h1>
          </div>
        </div>
        <div className={'row'}>
          <div className={'col-10'}>
            Personnel
            <ul>
              {siteUsersInfo.map((user) => (
                  <li key={user.id}>
                    {user.firstname} {user.lastname}
                  </li>
              ))}
            </ul>
            <hr/>
            Matériel
            <ul>
              {siteEquipmentsInfo.map((equipment) => (
                  <li key={equipment.id}>
                    {equipment.name}
                  </li>
              ))}
            </ul>
          </div>
        </div>
      </div>
  )
}

export default SiteShow;

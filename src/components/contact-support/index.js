

const { Component, RawHTML } = wp.element;
import { Panel, PanelRow, PanelItem, Button, Dropdown, SelectControl, Popover } from '@wordpress/components'
import { createElement, useCallback, memo, useMemo, useState, useEffect } from '@wordpress/element'

import { __experimentalInputControl as InputControl } from '@wordpress/components';
import { link, linkOff } from "@wordpress/icons";




class PGContactSupport extends Component {







  render() {

    var {

      utm,


    } = this.props;




    function ContactHtml(props) {

      var utmPrams = new URLSearchParams(utm).toString();


      var docUrl = 'https://comboblocks.com/documentations/?' + utmPrams + '&utm_medium=Docsbutton';
      var tutsUrl = 'https://www.youtube.com/playlist?list=PL0QP7T2SN94bpTVghETSePuVvRROpuEW6';
      var supportCreate = 'https://pickplugins.com/create-support-ticket/?' + utmPrams + '&utm_medium=createSupportButton';
      var reviewUrl = 'https://wordpress.org/support/plugin/team/reviews/#new-post';



      return (

        <div className='grid grid-cols-2 gap-2 my-2'>


          <div className=''>
            <a target="_blank" href={docUrl} className='bg-blue-600 hover:text-white font-bold text-[16px] px-5 py-2 block text-center text-white rounded no-underline '>Docs</a>
          </div>
          <div className=''>
            <a target="_blank" href={tutsUrl} className='bg-blue-600 hover:text-white font-bold text-[16px] px-5 py-2 block text-center text-white rounded no-underline '>Tutorials</a>
          </div>
          <div className='col-span-2'>
            <a target="_blank" href={supportCreate} className='bg-blue-600 hover:text-white font-bold text-[16px] px-5 py-2 block text-center text-white rounded no-underline '>Create Support Ticket</a>
          </div>
          <div className='col-span-2'>
            <a target="_blank" href={reviewUrl} className='bg-amber-500 hover:text-white font-bold text-[16px] px-5 py-2  text-center text-white rounded no-underline flex gap-2 justify-center items-center '><span className="dashicons dashicons-star-filled"></span> Write Your Reviews</a>
          </div>

        </div>

      )

    }


    return (

      <>
        <ContactHtml utm={utm} />

      </>

    )
  }
}


export default PGContactSupport;
import faker from 'faker'
import { last } from 'lodash'
const password = 'ped86KingWebmapp'

describe('Registration', () => {
    const email = 'gianmarcogagliardi@webmapp.it'
    const password = 'ped86KingWebmapp'
    var id


  it('create new POI by Mario', () => {
      cy.visit('https://test.montepisanotree.org/wp-admin')
      cy.get('input[name=log]').type(email)
      cy.get('input[name=pwd]').type(password)
      cy.get('input#wp-submit').click()
      cy.url().should('contain', '/')
      cy.get('.wp-menu-name').contains('POI').click()
      cy.get('#wpbody-content > div.wrap > a').contains('Add New').click()
      var title = tree_title()
      cy.get('input[name=post_title]').type(title)
      cy.get('textarea#acf-field_592437f867717').type('test automatico by Mario')
      cy.get('#acf-field_58528c8fff96b > div.title > input').type('43.7633840,10.5031350')
      cy.get('#acf-field_58528c8fff96b > div.title > div > a.acf-icon.-search.grey').click({ force: true })
      cy.wait(3000)
      cy.get('input[type=submit]').contains('Pubblica').click({ force: true })
      cy.visit('https://test.montepisanotree.org/wp-admin/edit.php?post_type=poi')
      cy.get('tbody#the-list td').first().invoke('val').as('id')
      cy.get('tbody#the-list td').first().invoke('text').then((value) => {
        id = value.substring(0, 4);
        cy.log(value)
        cy.log(id)
        // cy.wait(3000)

        // cy.request({
        //     url: 'https://hoqustaging.webmapp.it/'+id+'/show',
        //     headers:{
        //         Authorization: 'Bearer SXakAvk01hbXD5zKLQ0tt6QAvmKWpq0IQ26WT6yC'
        //     }
        // })
        // .then((resp) => {
        //     // redirect status code is 302
        //     expect(resp.status).to.eq(200)
        // })

     })

      cy.request({
        url: 'https://test.montepisanotree.org/poi/'+title
          })
        .then((resp) => {
          // redirect status code is 302
          expect(resp.status).to.eq(200)
        })

        cy.request({
          url: 'https://test.montepisanotree.org/?p='+id
            })
          .then((resp) => {
            // redirect status code is 302
            expect(resp.status).to.eq(200)
          })

   })

//    it('id', () => {
//     cy.visit('https://hoqustaging.webmapp.it/')
//     cy.get('input[name=email]').type('team@webmapp.it')
//     cy.get('input[name=password]').type('31xwdf.f')
//     cy.get('button').contains('Login').click()
//     cy.get('@id').then((id) => {
//        cy.get('#hometable > tbody > tr > td:nth-child(4)').each(($e, index, $list) => {
//           const text = $e.text()
//           cy.log(id)
//           if (text.includes(id)) { //if I put a number instead of id it works
//              assert.strictEqual(text, '{"id":' + id + '}', 'id nedo ok')
//           }
//        })
//     })
//  })



//    it('Gabriella buys a POI by in love', () => {
//     cy.visit('https://test.montepisanotree.org/poi/666')
//     cy.url().should('contain', 'https://test.montepisanotree.org/poi/666')
//     cy.get('a.btn._mPS2id-h').contains('Adotta ora!').click()
//     cy.get('button.single_add_to_cart_button.button.alt').contains('Love').click()



//     })
function tree_title() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 10; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  })



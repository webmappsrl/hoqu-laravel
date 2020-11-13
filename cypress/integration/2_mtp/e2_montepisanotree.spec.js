
describe('Final Test', () => {
    const email = 'gianmarcogagliardi@webmapp.it'
    const password = 'ped86KingWebmapp'
    var id
    var title

    it('Mario create POI', () => {
        cy.visit('https://test.montepisanotree.org/wp-admin')
        cy.get('input[name=log]').type(email)
        cy.get('input[name=pwd]').type(password)
        cy.get('input#wp-submit').click()
        cy.url().should('contain', '/')
        //create POI
        cy.get('.wp-menu-name').contains('POI').click()
        cy.get('#wpbody-content > div.wrap > a').contains('Add New').click()
        title = tree_title()
        cy.get('input[name=post_title]').type(title)
        cy.get('textarea#acf-field_592437f867717').type('test automatico by Mario')
        cy.get('#acf-field_58528c8fff96b > div.title > input').type('43.7633840,10.5031350')
        cy.get('#acf-field_58528c8fff96b > div.title > div > a.acf-icon.-search.grey').click({
            force: true
        })
        cy.get('#in-webmapp_category-108').click()
        cy.wait(5000)
        cy.get('input[type=submit]').contains('Pubblica').click({
            force: true
        })
        cy.visit('https://test.montepisanotree.org/wp-admin/edit.php?post_type=poi')
        cy.url().should('contain', 'https://test.montepisanotree.org/wp-admin/edit.php?post_type=poi')

        cy.get('tbody#the-list td').first().invoke('text').then((value) => {
            id = value.substring(0, 4);
            cy.wait(10000)
            cy.request({
                    url: 'https://test.montepisanotree.org/?p=' + id
                })
                .then((resp) => {
                    // assert status code is 200
                    expect(resp.status).to.eq(200)
                })
        })
        //previously created POI check for server response and POI color
        cy.request({
                url: 'https://test.montepisanotree.org/poi/' + title
            })
            .then((resp) => {
                // assert status code is 200
                expect(resp.status).to.eq(200)
            })
        cy.get('tbody#the-list td').first().invoke('val').as('id')
        cy.wait(2000)
        cy.visit('https://test.montepisanotree.org/poi/' + title)
        //assert the color of POI
        cy.get('path').eq(4).should('have.attr', 'fill', '#0fb500')

    })

    it('Raffaella buys a POI by in love', () => {
        cy.visit('https://test.montepisanotree.org/poi/' + title)
        cy.url().should('contain', 'https://test.montepisanotree.org/poi/' + title)
        //assert the color of POI
        cy.get('path').eq(4).should('have.attr', 'fill', '#0fb500')
        cy.wait(2000)
        cy.get('a.btn._mPS2id-h').contains('Adotta ora!').click()
        cy.get('button.single_add_to_cart_button.button.alt').contains('Love').click()
        cy.wait(3000)
        //assert redirect in carrello
        cy.url().should('contain', 'https://test.montepisanotree.org/carrello')
        cy.get('#wrapper > div.cf > div > div > div > div > div > div > div > div > div > div.row > div.small-12.large-4.xlarge-3.columns > div > div > div > a').click()
        cy.wait(2000)
        //assert redirect in checkout
        cy.url().should('contain', 'https://test.montepisanotree.org/checkout')
        //entering personal data
        cy.get('#billing_codice_fiscale').type('FNTRFL80A41G702D')
        cy.get('#billing_first_name').type('Raffaella')
        cy.get('#billing_last_name').type('Fantozzi')
        cy.get('#select2-billing_country-container').click()
        cy.get('li[id*="select2-billing_country"]').eq(2).click()
        cy.get('input#billing_address_1').type('via del nugolaio')
        cy.get('input#billing_city').type('Kabul')
        cy.get('input#billing_postcode').type('Kabul')
        cy.get('input#billing_phone').type('166101010')
        cy.get('input#billing_email').type('raffaellapzzt@pzzt.com')
        //credit card data entry
        cy.getIframe('#stripe-card-element > .__PrivateStripeElement > iframe').click().type('4242 4242 4242 4242')
        cy.getIframe('#stripe-exp-element > .__PrivateStripeElement > iframe').click().type('0922')
        cy.getIframe('#stripe-cvc-element > .__PrivateStripeElement > iframe').click().type('123')
        cy.get('input#terms').click()
        cy.get('input#privacy_policy').click()
        cy.wait(1000)
        cy.get('button#place_order').click()
        cy.wait(10000)
        //assert the color of POI
        cy.visit('https://test.montepisanotree.org/poi/' + title)
        cy.url().should('contain', 'https://test.montepisanotree.org/poi/' + title)
        cy.get('path').eq(4).should('have.attr', 'fill', '#dd3333')
    })

    function tree_title() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }

})

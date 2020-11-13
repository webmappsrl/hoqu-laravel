describe('Final Test Sentiero Italia E2E2', () => {
    const email = 'gagliardi'
    const password = 'webmappForHoqu'
    var id
    var title
    var osmid
    var objPre
    var objPost
    var check

    it('update track no geometry', () => {
        cy.visit('http://els.be.webmapp.it/wp-admin')
        cy.get('input[name=log]').type(email)
        cy.get('input[name=pwd]').type(password)
        cy.get('input#wp-submit').click()
        cy.url().should('contain', '/')
        //update TRACK
        cy.get('#menu-posts-track > a > div.wp-menu-name').click()
        cy.wait(2000)
        cy.get('tbody#the-list td').first().invoke('text').then((value) => {
            cy.log(value)
            id = value.substring(0, 4);
            cy.request('GET', 'https://a.webmapp.it/els.be.webmapp.it/geojson/' + id + '.geojson').then((response) => {
                objPre = JSON.parse(response.body)
                objPre = JSON.stringify(objPre.geometry)

                cy.visit('http://els.be.webmapp.it/wp-admin/post.php?post=' + id + '&action=edit&lang=it')

                title = tree_title()
                cy.get('#post-title-0').clear({
                    force: true
                })
                cy.get('#post-title-0').type(title)
                cy.get('input#acf-wm_track_osmid').invoke('val').then((osm) => {
                    cy.log(osm)
                    osmid = osm
                    cy.get('#editor > div > div > div.components-navigate-regions > div > div.block-editor-editor-skeleton__header > div > div.edit-post-header__settings > button.components-button.editor-post-publish-button.editor-post-publish-button__button.is-primary').click()
                    cy.wait(20000)

                    cy.request('GET', 'https://a.webmapp.it/els.be.webmapp.it/geojson/' + id + '.geojson').then((response) => {
                        const obj = JSON.parse(response.body)
                        objPost = JSON.stringify(obj.geometry)
                        assert.strictEqual(obj.properties.name, title, 'ok title')
                        assert.strictEqual(obj.properties.osmid, osmid, 'ok osmid')
                        check = objPost.localeCompare(objPre)
                        assert.equal(check, 0, 'no geometry ok ')
                    })
                })
            })
        })

    })
    function tree_title() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }

})

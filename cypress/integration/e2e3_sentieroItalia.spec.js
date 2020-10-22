describe('Final Test Sentiero Italia E2E3', () => {
    const email = 'gagliardi'
    const password = 'webmappForHoqu'
    var id
    var osmid
    var objPre
    var objPost
    var check

    it('update track geometry', () => {
        cy.visit('http://els.be.webmapp.it/wp-admin')
        cy.get('input[name=log]').type(email)
        cy.get('input[name=pwd]').type(password)
        cy.get('input#wp-submit').click()
        cy.url().should('contain', '/')
        cy.get('#menu-posts-track > a > div.wp-menu-name').click()
        cy.wait(2000)
        cy.get('tbody#the-list td').first().invoke('text').then((value) => {
            id = value.substring(0, 4);
            cy.request('GET', 'https://a.webmapp.it/els.be.webmapp.it/geojson/' + id + '.geojson').then((response) => {
                objPre = JSON.parse(response.body)
                objPre = JSON.stringify(objPre.geometry)

                cy.visit('http://els.be.webmapp.it/wp-admin/post.php?post=' + id + '&action=edit&lang=it')

                cy.get('input#acf-wm_track_osmid').invoke('val').then((osm) => {
                    osmid = osm
                    cy.get('input#acf-wm_track_osmid').clear({
                        force: true
                    })
                    cy.get('input#acf-wm_track_osmid').type('4179533')
                    cy.get('button.button.button-secondary').contains('Update').click()
                    cy.wait(2000)
                    cy.get('#editor > div > div > div.components-navigate-regions > div > div.block-editor-editor-skeleton__header > div > div.edit-post-header__settings > button.components-button.editor-post-publish-button.editor-post-publish-button__button.is-primary').click()
                    cy.wait(20000)

                    cy.request('GET', 'https://a.webmapp.it/els.be.webmapp.it/geojson/' + id + '.geojson').then((response) => {
                        const obj = JSON.parse(response.body)
                        objPost = JSON.stringify(obj.geometry)
                        assert.notStrictEqual(obj.properties.osmid, osmid, 'ok not osmid')
                        check = objPost.localeCompare(objPre)
                        assert.notEqual(check, 0, 'change geometry ok ')
                    })
                    cy.visit('http://els.be.webmapp.it/wp-admin/post.php?post=' + id + '&action=edit&lang=it')
                    cy.get('input#acf-wm_track_osmid').clear()
                    cy.get('input#acf-wm_track_osmid').type(osmid)
                    cy.get('button.button.button-secondary').contains('Update').click()
                    cy.wait(2000)
                    cy.get('#editor > div > div > div.components-navigate-regions > div > div.block-editor-editor-skeleton__header > div > div.edit-post-header__settings > button.components-button.editor-post-publish-button.editor-post-publish-button__button.is-primary').click()
                })

            })

        })

    })

})

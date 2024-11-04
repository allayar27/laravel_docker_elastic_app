<template>
    <div class="app-container">
    <div id="autocomplete">
    </div>
    </div>
</template>

<script>

    import { h, Fragment, render, onMounted } from 'vue';
    import algoliasearch from 'algoliasearch/lite';
    import { autocomplete, getAlgoliaResults } from '@algolia/autocomplete-js';

    


    import '@algolia/autocomplete-theme-classic';

    const searchClient = algoliasearch(
    '6P3J1M2CVG', 'cf96758c66657f78d06fe8e09b84d38f'
    );

    

    export default {
    name: 'App',
    setup() {
        onMounted(() => {

            autocomplete({
                container: '#autocomplete',
                placeholder: 'Algolia search',
                insights: true,
                openOnFocus: true,
                getSources({ query }) {
                    return [
                        {
                            sourceId: 'users',
                            getItems() {
                                return getAlgoliaResults({
                                    searchClient,
                                    queries: [
                                        {
                                            indexName: 'users',
                                            query,
                                            params: {
                                                hitsPerPage: 5,
                                                attributesToSnippet: ['name', 'email'],
                                                snippetEllipsisText: '…',
                                            },
                                        },
                                    ],
                                });
                            },
                            templates: {
                                item({ item, components, html }) {
                                    return html`<div class="aa-ItemWrapper">
                                                    <div class="aa-ItemContent">
                                                        <div class="aa-ItemContentBody">
                                                            <div class="aa-ItemContentTitle">
                                                            ${components.Highlight({
                                                                hit: item,
                                                                attribute: 'name',
                                                            })}
                                                            </div>
                                                            <div class="aa-ItemContentDescription">
                                                            ${components.Snippet({
                                                                    hit: item,
                                                                    attribute: 'email',
                                                            })}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                },
                            },
                        },
                    ];
                },
            });

        });
   
    },
};
</script>
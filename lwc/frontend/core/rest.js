export async function eventAppByTabId(tabId) {
    return await fetch(
        `https://krasnagorka.by/wp-json/krasnagorka/v1/ls/event-tab/?tabId=${tabId}`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            }
        }
    ).then((result) => result.json())
}

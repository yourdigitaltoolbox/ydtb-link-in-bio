/**
 * @param {import('@roots/bud').Bud} bud
 */
export default (bud) => {
  bud.hash()
  bud.alias(`@client`, bud.path(`@src`, `client`))
  bud.entry(`client`, [`@client/index.tsx`, `@client/styles/client.css`])
  bud.proxy('https://wp.dev')
};

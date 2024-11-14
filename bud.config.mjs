/**
 * @param {import('@roots/bud').Bud} bud
 */


export default async (bud) => {
  bud.hash()
  bud.alias(`~`, bud.path(`@src`, `client`))
  bud.entry(`client`, [`~/index.tsx`, `~/styles/client.css`])
  bud.setUrl('http://localhost:3000')
  bud.setProxyUrl('http://dev.test/')
  bud.watch(['./src/client/', './src/client/**/*'])

  bud.build.items.precss.setLoader('minicss');
  bud.hooks.action('build.before', (bud) => {
    bud.extensions.get('@roots/bud-extensions/mini-css-extract-plugin').enable(true);
  });
};

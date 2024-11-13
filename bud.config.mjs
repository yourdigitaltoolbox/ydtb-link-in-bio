/**
 * @param {import('@roots/bud').Bud} bud
 */


export default async (bud) => {
  bud.hash()
  bud.alias(`~`, bud.path(`@src`, `client`))
  bud.entry(`client`, [`~/index.tsx`, `~/styles/client.css`])
  bud.proxy('https://dev-ydtb.link/')
  bud.watch(['./src/client/', './src/client/**/*'])

  bud.build.items.precss.setLoader('minicss');
  bud.hooks.action('build.before', (bud) => {
    bud.extensions.get('@roots/bud-extensions/mini-css-extract-plugin').enable(true);
  });

};

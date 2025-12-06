/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  experimental: {
    serverActions: true, // optional, if you need server actions
  },
  turbopack: {
    // You can leave empty object or remove it if not using Turbopack
  },
};

module.exports = nextConfig;

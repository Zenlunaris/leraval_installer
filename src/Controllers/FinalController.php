<?php

namespace Zenlunaris\LevaralInstaller\Controllers;

use Illuminate\Routing\Controller;
use Zenlunaris\LevaralInstaller\Events\LaravelInstallerFinished;
use Zenlunaris\LevaralInstaller\Helpers\EnvironmentManager;
use Zenlunaris\LevaralInstaller\Helpers\FinalInstallManager;
use Zenlunaris\LevaralInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Zenlunaris\LevaralInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Zenlunaris\LevaralInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Zenlunaris\LevaralInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
